<?php
/**
 * Created by PhpStorm.
 * User: raymund
 * Date: 20.02.2016
 * Time: 19:42
 */

namespace tests\capsule;

use AnthonyMartin\GeoLocation\GeoLocation;
use Illuminate\Database\Capsule\Manager as Capsule;
use Rox\Models\Activity;
use stdClass;

class CapsuleTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $params = parse_ini_file('rox_local.ini');

        $parts = explode('=', $params['dsn']);

        $host = substr($parts[1], 0, strpos($parts[1], ';'));
        $db = $parts[2];
        $user = $params['user'];
        $password = $params['password'];

        // Setup database connection with Eloquent
        $capsule = new Capsule();
        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => $host,
            'database' => $db,
            'username' => $user,
            'password' => $password,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public function testGeonames() {
        $result = Capsule::table('geonames')->where('geonameid', 123456)->first(['latitude', 'longitude']);
        
        $distance = 25;
        $edison = GeoLocation::fromDegrees($result->latitude, $result->longitude);
        $coordinates = $edison->boundingCoordinates($distance, 'km');
        $result = new stdClass;
        $result->latne = $coordinates[0]->getLatitudeInDegrees();
        $result->longne = $coordinates[0]->getLongitudeInDegrees();
        $result->latsw = $coordinates[1]->getLatitudeInDegrees();
        $result->longsw = $coordinates[1]->getLongitudeInDegrees();

        $query = Activity::where(function ($query) {
            $query->where('dateTimeStart', '>=', Capsule::raw('NOW()'))
                ->orWhere('dateTimeEnd', '>=', Capsule::raw('NOW()'));
        })
            ->where('status', 0)
            ->join('geonames', function($join) use($result) {
            ->join->on('activities.locationId', '=', 'geonames.geonameId')
                ->where('latitude', '<=', $result->latsw)
                ->where('latitude', '>=', $result->latne)
                ->where('longitude', '<=', $result->longsw)
                ->where('longitude', '>=', $result->longne);
        })
            ->where(;

        return $result;
    }
}
