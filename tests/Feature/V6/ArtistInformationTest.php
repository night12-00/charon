<?php

namespace Tests\Feature\V6;

use App\Models\Artist;
use App\Services\MediaInformationService;
use App\Values\ArtistInformation;
use Mockery;

class ArtistInformationTest extends TestCase
{
    private const JSON_STRUCTURE = [
        'url',
        'image',
        'bio' => [
            'summary',
            'full',
        ],
    ];

    public function testGet(): void
    {
        config(['charon.lastfm.key' => 'foo']);
        config(['charon.lastfm.secret' => 'geheim']);

        /** @var Artist $artist */
        $artist = Artist::factory()->create();

        $lastfm = self::mock(MediaInformationService::class);
        $lastfm->shouldReceive('getArtistInformation')
            ->with(Mockery::on(static fn (Artist $a) => $a->is($artist)))
            ->andReturn(ArtistInformation::make(
                url: 'https://lastfm.com/artist/foo',
                image: 'https://lastfm.com/image/foo',
                bio: [
                    'summary' => 'foo',
                    'full' => 'bar',
                ],
            ));

        $this->getAs('api/artists/' . $artist->id . '/information')
            ->assertJsonStructure(self::JSON_STRUCTURE);
    }

    public function testGetWithoutLastfmStillReturnsValidStructure(): void
    {
        config(['charon.lastfm.key' => null]);
        config(['charon.lastfm.secret' => null]);

        /** @var Artist $artist */
        $artist = Artist::factory()->create();

        $this->getAs('api/artists/' . $artist->id . '/information')
            ->assertJsonStructure(self::JSON_STRUCTURE);
    }
}
