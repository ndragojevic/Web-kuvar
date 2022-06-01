<?php

use App\Http\Controllers\GostController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\KorisnikNamRecController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Gost;
use App\Http\Controllers\Korisnik;
use App\Models\OmiljeniModel;
use Illuminate\Http\Request;

use App\Models\KomentarModel;
use App\Models\KorisnikModel;
use App\Models\ReceptModel;

use App\Models\NamirniceReceptModel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/recepti', [KorisnikNamRecController::class, "filtrirajRecepte"])->name("filtrirajRecepte");

Route::post('/receptiGost', [KorisnikNamRecController::class, "filtrirajRecepteGost"])->name("filtrirajRecepteGost");

Route::get('/recepti', [KorisnikNamRecController::class, "recepti"])->name('recepti');

Route::post('/recepti/{id}', [KorisnikNamRecController::class, "generisiReceptePoNamirnicamaKorinsika"])->name("generisiReceptePoNamirnicamaKorinsika");


Route::patch('/recepti/id={ReceptId}/ocena={ocena}', [KorisnikNamRecController::class, "oceniRecept"])->name("oceniRecept");

Route::get('/namirnice/{id}', [KorisnikNamRecController::class, "prikaziKorisnikoveNamirnice"])->name("prikaziKorisnikoveNamirnice");

Route::post('/namirnice/id={id}/naziv={naziv}/Kolicina={kolicina}', [KorisnikNamRecController::class, "dodajNamirnicu"])->name("dodajNamirnicu");

Route::delete('/namirnice/ukloni/{id}', [KorisnikNamRecController::class, "ukloniNamirnicu"])->name("ukloniNamirnicu");


Route::get('/', [Gost::class, "index"])->name('index');
Route::get('/registracija', [Gost::class, "registracija"])->name('registracija');
Route::post('/regsubmit', [Gost::class, "regsubmit"])->name('regsubmit');
Route::get('/login', [Gost::class, "prijava"])->name('login');
Route::post('/loginsubmit', [Gost::class, "login_submit"])->name('login_submit');
Route::get('/pocetna', [Korisnik::class, "pocetna"])->name('pocetna');
Route::get('/dodajrecept', [Korisnik::class, "dodajrecept"])->name('dodajrecept');
Route::post('/novirecept', [Korisnik::class, "novirecept"])->name('novirecept');
Route::post('/novirecept2', [Korisnik::class, "novirecept2"])->name('novirecept2');
Route::post('/novanamirnica', [Korisnik::class, "novanamirnica"])->name('novanamirnica');
Route::get('/pregled', [Korisnik::class, "pregled"])->name('pregled');


Route::get('dodajomiljeni/{recept}', function ($recept) {
    $kor = KorisnikModel::where('KorId', session()->get('korid'))->first();
    $omiljeni = OmiljeniModel::create([
        'ReceptId' => $recept,

        'KorId' => session()->get('korid')
    ]);
    $omiljeni->save();

    $r = ReceptModel::find($recept);
    $kom = KomentarModel::where('ReceptId', $recept)->get();
    $namirnice = NamirniceReceptModel::where('ReceptId', $recept)->get();
    return view('recept', ['recept' => $r, 'komentari' => $kom, 'namirnice' => $namirnice, "kor" => $kor]);
})->name('dodajomiljeni');

Route::get('obrisimirnicu/{nim}', function ($nim) {
    NamirniceReceptModel::where('NamId', $nim)->delete();
    $namirnice = NamirniceReceptModel::where('ReceptId', session()->get('rid'))->get();

    return view('dodajnamirnice', ['namirnice' => $namirnice]);
})->name('obrisimirnicu');

Route::get('receptpregled/{recept}', function ($recept) {

    $r = ReceptModel::find($recept);
    $kom = KomentarModel::where('ReceptId', $recept)->get();
    $namirnice = NamirniceReceptModel::where('ReceptId', $recept)->get();
    $korisnik = KorisnikModel::where('KorId', session()->get('korid'))->first();

    if ($korisnik->rola == 'user') {
        return view('recept', ['recept' => $r, 'komentari' => $kom, 'namirnice' => $namirnice, "kor" => $korisnik]);
    } else  return view('receptA', ['recept' => $r, 'komentari' => $kom, 'namirnice' => $namirnice, "kor" => $korisnik]);
})->name('receptpregled');

Route::get('receptpregledGost/{recept}', function ($recept) {

    $r = ReceptModel::find($recept);
    $kom = KomentarModel::where('ReceptId', $recept)->get();
    $namirnice = NamirniceReceptModel::where('ReceptId', $recept)->get();
    return view('receptGost', ['recept' => $r, 'komentari' => $kom, 'namirnice' => $namirnice]);
})->name('receptpregledGost');

Route::get('/omrecepti', [Korisnik::class, "omrecepti"])->name('omrecepti');

Route::get('/mojirecepti', [Korisnik::class, "mojirecepti"])->name('mojirecepti');

Route::get('komentarir/{rid}', function ($rid) {

    $kom = KomentarModel::where('ReceptId', $rid)->get();
    $r = ReceptModel::where('ReceptId', $rid)->first();

    $korisnik = KorisnikModel::where('KorId', session()->get('korid'))->first();

    if ($korisnik->rola == 'user') {
        return view('komentar', ['kom' => $kom, 'recept' => $r, "kor" => $korisnik]);
    } else {
        return view('komentarA', ['kom' => $kom, 'recept' => $r, "kor" => $korisnik]);
    }
})->name('komentarir');

Route::get(
    'brisanjeK/{kid}/comm/{rid}',
    function ($kid, $rid) {

        KomentarModel::where('KomId', $kid)->delete();
        $kom = KomentarModel::where('ReceptId', $rid)->get();
        $r = ReceptModel::where('ReceptId', $rid)->first();
        $korisnik = KorisnikModel::where('KorId', session()->get('korid'))->first();
        return view('komentarA', ['kom' => $kom, 'recept' => $r, "kor" => $korisnik]);
    }
)->name('brisanjeK');

Route::get('komentarirGost/{rid}', function ($rid) {

    $kom = KomentarModel::where('ReceptId', $rid)->get();
    $r = ReceptModel::where('ReceptId', $rid)->first();
    $korisnik = KorisnikModel::where('KorId', session()->get('korid'))->first();

    return view('komentarGost', ['kom' => $kom, 'recept' => $r, "kor" => $korisnik]);
})->name('komentarirGost');

Route::get('/pregledrecepataK', [Korisnik::class, "pregledrecepataK"])->name('pregledrecepataK');

Route::post('/novikomentar/{recept}', function (Request $request, $recept) {

    $kom = KomentarModel::create([
        'ReceptId' => $recept,
        'KorId' => $request->session()->get('korid'),
        'Tekst' => $request->kom
    ]);
    $kom->save();
    $r = ReceptModel::find($recept);
    $kom = KomentarModel::where('ReceptId', $recept)->get();
    $namirnice = NamirniceReceptModel::where('ReceptId', $recept)->get();
    $korisnik = KorisnikModel::where('KorId', session()->get('korid'))->first();
    return view('recept', ['recept' => $r, 'komentari' => $kom, 'namirnice' => $namirnice, "kor" => $korisnik]);
})->name('novikomentar');

Route::post('odjava', function (Request $request) {

    $request->session()->flush();
    $r = ReceptModel::all();
    return view('index', ['recepti' => $r]);
})->name('odjava');

Route::post('brisanjeR/{recept}', function (Request $request, $recept) {

    NamirniceReceptModel::where('ReceptId', $recept)->delete();
    KomentarModel::where('ReceptId', $recept)->delete();
    OmiljeniModel::where('ReceptId', $recept)->delete();
    ReceptModel::where('ReceptId', $recept)->delete();
    $r = ReceptModel::all();
    $korisnik = KorisnikModel::where('KorId', session()->get('korid'))->first();
    return view("pocetna", ['recepti' => $r, "kor" => $korisnik]);
})->name('brisanjeR');
