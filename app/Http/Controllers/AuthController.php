<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * @api {post} /api/login Bejelentkezés
 * @apiVersion 1.0.0
 * @apiName LoginUser
 * @apiGroup Authentication
 * @apiPermission public
 *
 * @apiDescription Hitelesíti a felhasználót az e-mail cím és a jelszó alapján, majd visszaad egy Sanctum API tokent.
 *
 * @apiBody {String} email Felhasználó e-mail címe (kötelező, érvényes email formátum).
 * @apiBody {String} password Felhasználó jelszava (kötelező).
 *
 * @apiParamExample {json} Kérés példa:
 *     {
 *       "email": "user@example.com",
 *       "password": "titkosjelszo"
 *     }
 *
 * @apiSuccess {Object} user A bejelentkezett felhasználó adatai.
 * @apiSuccess {Number} user.id Felhasználó egyedi azonosítója.
 * @apiSuccess {String} user.name Felhasználó neve.
 * @apiSuccess {String} user.email Felhasználó e-mail címe.
 * @apiSuccess {String} user.created_at Létrehozás dátuma.
 * @apiSuccess {String} user.updated_at Módosítás dátuma.
 * @apiSuccess {String} token A generált Laravel Sanctum hozzáférési token (Bearer token).
 *
 * @apiSuccessExample {json} Sikeres válasz:
 *     HTTP/1.1 200 OK
 *     {
 *       "user": {
 *         "id": 1,
 *         "name": "Teszt Elek",
 *         "email": "user@example.com",
 *         "created_at": "2026-01-01T00:00:00.000000Z",
 *         "updated_at": "2026-01-01T00:00:00.000000Z"
 *       },
 *       "token": "1|laravel_sanctum_token_string_example..."
 *     }
 *
 * @apiError (Hiba: 401) Unauthorized Hibás e-mail cím vagy jelszó.
 * @apiErrorExample {json} Hiba válasz (401):
 *     HTTP/1.1 401 Unauthorized
 *     {
 *       "message": "Invalid email or password"
 *     }
 *
 * @apiError (Hiba: 422) UnprocessableEntity Validációs hiba (pl. hiányzó vagy rossz formátumú e-mail).
 */
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password',
            ], 401);
        }

        $token = $user->createToken('access')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }
}