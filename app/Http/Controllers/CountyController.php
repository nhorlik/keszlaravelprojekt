<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\County;

/**
 * @api {get} /api/counties Lekérdezés (Összes megye)
 * @apiVersion 1.0.0
 * @apiName GetCounties
 * @apiGroup Counties
 * @apiPermission public
 *
 * @apiDescription Visszaadja az összes megye listáját.
 *
 * @apiSuccess {Object[]} counties Megyék listája.
 * @apiSuccess {Number} counties.id Megye egyedi azonosítója.
 * @apiSuccess {String} counties.name Megye neve.
 * @apiSuccess {String} counties.created_at Létrehozás dátuma.
 * @apiSuccess {String} counties.updated_at Módosítás dátuma.
 *
 * @apiSuccessExample {json} Sikeres válasz:
 *     HTTP/1.1 200 OK
 *     {
 *       "counties": [
 *         {
 *           "id": 1,
 *           "name": "Pest",
 *           "created_at": "2026-01-01T00:00:00.000000Z",
 *           "updated_at": "2026-01-01T00:00:00.000000Z"
 *         }
 *       ]
 *     }
 */

/**
 * @api {post} /api/counties Létrehozás (Új megye)
 * @apiVersion 1.0.0
 * @apiName PostCounty
 * @apiGroup Counties
 * @apiPermission admin
 *
 * @apiDescription Létrehoz egy új megyét a megadott adatokkal.
 *
 * @apiBody {String} name Megye neve (kötelező, max 255 karakter).
 *
 * @apiParamExample {json} Kérés példa:
 *     {
 *       "name": "Pest"
 *     }
 *
 * @apiSuccess {Object} county Létrehozott megye adatai.
 * @apiSuccess {Number} county.id Megye egyedi azonosítója.
 * @apiSuccess {String} county.name Megye neve.
 * @apiSuccess {String} county.updated_at Módosítás dátuma.
 * @apiSuccess {String} county.created_at Létrehozás dátuma.
 *
 * @apiSuccessExample {json} Sikeres válasz:
 *     HTTP/1.1 200 OK
 *     {
 *       "county": {
 *         "id": 1,
 *         "name": "Pest",
 *         "updated_at": "2026-10-19T10:00:00.000000Z",
 *         "created_at": "2026-10-19T10:00:00.000000Z"
 *       }
 *     }
 *
 * @apiError (Hiba: 422) UnprocessableEntity Validációs hiba (pl. hiányzó név).
 */

/**
 * @api {put} /api/counties/:id Módosítás (Megye szerkesztése)
 * @apiVersion 1.0.0
 * @apiName PutCounty
 * @apiGroup Counties
 * @apiPermission admin
 *
 * @apiDescription Frissíti egy létező megye adatait az ID alapján.
 *
 * @apiParam {Number} id Megye egyedi azonosítója.
 *
 * @apiBody {String} [name] Megye új neve (opcionális).
 *
 * @apiSuccess {Object} county A frissített megye adatai.
 * @apiSuccess {Number} county.id Megye egyedi azonosítója.
 * @apiSuccess {String} county.name Megye neve.
 *
 * @apiSuccessExample {json} Sikeres válasz:
 *     HTTP/1.1 200 OK
 *     {
 *       "county": {
 *         "id": 1,
 *         "name": "Pest módosítva"
 *       }
 *     }
 *
 * @apiError (Hiba: 404) NotFound A megadott ID-val nem található megye.
 */

/**
 * @api {delete} /api/counties/:id Törlés (Megye törlése)
 * @apiVersion 1.0.0
 * @apiName DeleteCounty
 * @apiGroup Counties
 * @apiPermission admin
 *
 * @apiDescription Töröl egy megyét a megadott ID alapján.
 *
 * @apiParam {Number} id Megye egyedi azonosítója.
 *
 * @apiSuccess {String} message Sikeres törlési üzenet.
 *
 * @apiSuccessExample {json} Sikeres válasz:
 *     HTTP/1.1 200 OK
 *     {
 *       "message": "County deleted"
 *     }
 *
 * @apiError (Hiba: 404) NotFound A megadott ID-val nem található megye.
 */

/**
 * @api {get} /api/counties/search Keresés (Megyék szűrése név alapján)
 * @apiVersion 1.0.0
 * @apiName SearchCounties
 * @apiGroup Counties
 * @apiPermission public
 *
 * @apiDescription Megkeresi azokat a megyéket, amelyek neve tartalmazza a keresőkifejezést.
 *
 * @apiQuery {String} query Keresési kifejezés (kötelező, min. 1 karakter).
 *
 * @apiSuccess {Object[]} counties A találati listába eső megyék.
 *
 * @apiSuccessExample {json} Sikeres válasz:
 *     HTTP/1.1 200 OK
 *     {
 *       "counties": [
 *         {
 *           "id": 1,
 *           "name": "Pest"
 *         }
 *       ]
 *     }
 *
 * @apiError (Hiba: 422) UnprocessableEntity Hiányzik a query paraméter.
 */
class CountyController extends Controller
{
    // Megyék listázása a hozzájuk tartozó városokkal (1:N kapcsolat)
    public function index()
    {
        return response()->json([
            'counties' => County::all()
        ]);
    }

    // Új megye mentése (validációval)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $county = County::create($request->all());

        return response()->json([
            'county' => $county,
        ]);
    }

    // Meglévő megye módosítása ID alapján
    public function update(Request $request, $id)
    {
        $county = County::findOrFail($id);
        $county->update($request->all());

        return response()->json([
            'county' => $county,
        ]);
    }

    // Megye törlése ID alapján
    public function destroy($id)
    {
        $county = County::findOrFail($id);
        $county->delete();

        return response()->json([
            'message' => 'County deleted',
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:1',
        ]);

        $searchQuery = $request->input('query');

        $counties = County::where('name', 'LIKE', "%{$searchQuery}%")->get();

        return response()->json([
            'counties' => $counties,
        ]);
    }
}