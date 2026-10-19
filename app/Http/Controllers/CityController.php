<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\County;

/**
 * @api {get} /api/cities Lekérdezés (Összes város)
 * @apiVersion 1.0.0
 * @apiName GetCities
 * @apiGroup Cities
 * @apiPermission public
 *
 * @apiDescription Visszaadja az összes várost a hozzájuk tartozó megye (county) adataival együtt.
 *
 * @apiSuccess {Object[]} cities Városok listája.
 * @apiSuccess {Number} cities.id Város egyedi azonosítója.
 * @apiSuccess {String} cities.name Város neve.
 * @apiSuccess {Number} cities.county_id Megye azonosítója.
 * @apiSuccess {String} cities.created_at Létrehozás dátuma.
 * @apiSuccess {String} cities.updated_at Módosítás dátuma.
 * @apiSuccess {Object} cities.county A városhoz tartozó megye adatai.
 * @apiSuccess {Number} cities.county.id Megye egyedi azonosítója.
 * @apiSuccess {String} cities.county.name Megye neve.
 *
 * @apiSuccessExample {json} Sikeres válasz:
 *     HTTP/1.1 200 OK
 *     {
 *       "cities": [
 *         {
 *           "id": 1,
 *           "name": "Budapest",
 *           "county_id": 1,
 *           "created_at": "2026-01-01T00:00:00.000000Z",
 *           "updated_at": "2026-01-01T00:00:00.000000Z",
 *           "county": {
 *             "id": 1,
 *             "name": "Pest"
 *           }
 *         }
 *       ]
 *     }
 */

/**
 * @api {post} /api/cities Létrehozás (Új város)
 * @apiVersion 1.0.0
 * @apiName PostCity
 * @apiGroup Cities
 * @apiPermission admin
 *
 * @apiDescription Létrehoz egy új várost a megadott adatokkal.
 *
 * @apiBody {String} name Város neve (kötelező, max 255 karakter).
 * @apiBody {Number} county_id Megye ID-ja (kötelező, léteznie kell a counties táblában).
 *
 * @apiParamExample {json} Kérés példa:
 *     {
 *       "name": "Vác",
 *       "county_id": 1
 *     }
 *
 * @apiSuccess {Object} city Létrehozott város adatai.
 * @apiSuccess {Number} city.id Város egyedi azonosítója.
 * @apiSuccess {String} city.name Város neve.
 * @apiSuccess {Number} city.county_id Megye azonosítója.
 * @apiSuccess {String} city.updated_at Módosítás dátuma.
 * @apiSuccess {String} city.created_at Létrehozás dátuma.
 *
 * @apiSuccessExample {json} Sikeres válasz:
 *     HTTP/1.1 200 OK
 *     {
 *       "city": {
 *         "id": 2,
 *         "name": "Vác",
 *         "county_id": 1,
 *         "updated_at": "2026-10-19T10:00:00.000000Z",
 *         "created_at": "2026-10-19T10:00:00.000000Z"
 *       }
 *     }
 *
 * @apiError (Hiba: 422) UnprocessableEntity Validációs hiba (pl. hiányzó mező vagy nem létező county_id).
 */

/**
 * @api {put} /api/cities/:id Módosítás (Város szerkesztése)
 * @apiVersion 1.0.0
 * @apiName PutCity
 * @apiGroup Cities
 * @apiPermission admin
 *
 * @apiDescription Frissíti egy létező város adatait az ID alapján.
 *
 * @apiParam {Number} id Város egyedi azonosítója.
 *
 * @apiBody {String} [name] Város új neve (opcionális, ha módosul).
 * @apiBody {Number} [county_id] Új megye ID (opcionális).
 *
 * @apiSuccess {Object} city A frissített város adatai.
 * @apiSuccess {Number} city.id Város egyedi azonosítója.
 * @apiSuccess {String} city.name Város neve.
 * @apiSuccess {Number} city.county_id Megye azonosítója.
 *
 * @apiSuccessExample {json} Sikeres válasz:
 *     HTTP/1.1 200 OK
 *     {
 *       "city": {
 *         "id": 2,
 *         "name": "Vác módosítva",
 *         "county_id": 1
 *       }
 *     }
 *
 * @apiError (Hiba: 404) NotFound A megadott ID-val nem található város.
 */

/**
 * @api {delete} /api/cities/:id Törlés (Város törlése)
 * @apiVersion 1.0.0
 * @apiName DeleteCity
 * @apiGroup Cities
 * @apiPermission admin
 *
 * @apiDescription Töröl egy várost a megadott ID alapján.
 *
 * @apiParam {Number} id Város egyedi azonosítója.
 *
 * @apiSuccess {String} message Sikeres törlési üzenet.
 *
 * @apiSuccessExample {json} Sikeres válasz:
 *     HTTP/1.1 200 OK
 *     {
 *       "message": "City deleted"
 *     }
 *
 * @apiError (Hiba: 404) NotFound A megadott ID-val nem található város.
 */

/**
 * @api {get} /api/cities/search Keresés (Városok szűrése név alapján)
 * @apiVersion 1.0.0
 * @apiName SearchCities
 * @apiGroup Cities
 * @apiPermission public
 *
 * @apiDescription Megkeresi azokat a városokat, amelyek neve tartalmazza a keresőkifejezést.
 *
 * @apiQuery {String} query Keresési kifejezés (kötelező, min. 1 karakter).
 *
 * @apiSuccess {Object[]} cities A találati listába eső városok (megye adatokkal együtt).
 *
 * @apiSuccessExample {json} Sikeres válasz:
 *     HTTP/1.1 200 OK
 *     {
 *       "cities": [
 *         {
 *           "id": 2,
 *           "name": "Vác",
 *           "county_id": 1,
 *           "county": {
 *             "id": 1,
 *             "name": "Pest"
 *           }
 *         }
 *       ]
 *     }
 *
 * @apiError (Hiba: 422) UnprocessableEntity Hiányzik a query paraméter.
 */

/**
 * @api {get} /api/counties/:countyID/cities Lekérdezés megye szerint
 * @apiVersion 1.0.0
 * @apiName GetCitiesByCounty
 * @apiGroup Cities
 * @apiPermission public
 *
 * @apiDescription Visszaadja egy adott megyéhez tartozó összes várost.
 *
 * @apiParam {Number} countyID Megye egyedi azonosítója.
 *
 * @apiSuccess {Object[]} cities A megadott megyéhez tartozó városok listája.
 *
 * @apiSuccessExample {json} Sikeres válasz:
 *     HTTP/1.1 200 OK
 *     {
 *       "cities": [
 *         {
 *           "id": 2,
 *           "name": "Vác",
 *           "county_id": 1,
 *           "county": {
 *             "id": 1,
 *             "name": "Pest"
 *           }
 *         }
 *       ]
 *     }
 */
class CityController extends Controller
{
    public function index()
    {
        $cities = City::with('county')->get();
        return response()->json([
            'cities' => $cities,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'county_id' => 'required|exists:counties,id',
        ]);

        $city = City::create($request->all());

        return response()->json([
            'city' => $city,
        ]);
    }

    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        $city->update($request->all());

        return response()->json([
            'city' => $city,
        ]);
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return response()->json([
            'message' => 'City deleted',
        ]);
    }
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:1',
        ]);

        $searchQuery = $request->input('query');

        $cities = City::with('county')
            ->where('name', 'LIKE', "%{$searchQuery}%")
            ->get();

        return response()->json([
            'cities' => $cities,
        ]);
    }
    public function indexByCounty($countyID) {
        $query=City::with('county')->where('county_id','=',$countyID);
        $cities=$query->get();
        return response()->json([
            'cities' => $cities
        ]);
    }
}