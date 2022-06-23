<?php
namespace App\Bogur;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Tinify\AccountException;
use Tinify\ClientException;
use Tinify\ConnectionException;
use Tinify\ServerException;
use Tinify\Tinify;
use function Tinify\fromFile;

class Bogur {
    public static function cropAndTinifyImage($img) {
        try {
            Tinify::setKey('V8R3M74Ypc9bYFHW7TWmY6fSJqrwNSF7');

            $source = fromFile(Storage::path('public/user_photos/'.$img));
            $resized = $source->resize(array(
                "method" => "cover",
                "width" => 70,
                "height" => 70
            ));
            $resized->toFile(Storage::path('public/user_photos/'.$img));
        } catch(AccountException $e) {
            print("The error message is: " . $e->getMessage());
        } catch(ClientException $e) {
            print("The error message is: " . $e->getMessage());
        } catch(ServerException $e) {
            print("The error message is: " . $e->getMessage());
        } catch(ConnectionException $e) {
            print("The error message is: " . $e->getMessage());
        } catch(\Exception $e) {
            print("The error message is: " . $e->getMessage());
        }

    }

    public static function createToken() {
        $token = base64_encode(Str::random(30)."}");
        Cache::put('token', $token, now()->addMinutes(40));

        return $token;
    }
}
