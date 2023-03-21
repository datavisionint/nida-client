<?php

namespace SoftwareGalaxy\NidaClient\Tests;

use Illuminate\Filesystem\Filesystem;
use SoftwareGalaxy\NidaClient\Facades\NidaClient as FacadesNidaClient;
use SoftwareGalaxy\NidaClient\NidaClient;
use SoftwareGalaxy\NidaClient\NidaClientServiceProvider;

class ServiceProviderTest extends TestCase
{
    /** @var \Illuminate\Filesystem\Filesystem */
    protected mixed $filesystem;

    protected function setUp(): void
    {
        parent::setUp();

        $this->filesystem = $this->app->make(Filesystem::class);
    }

    public function test_registers_package(): void
    {
        static::assertArrayHasKey(NidaClientServiceProvider::class, $this->app->getLoadedProviders());
    }

    public function test_facades(): void
    {
        static::assertInstanceOf(NidaClient::class, FacadesNidaClient::getFacadeRoot());
    }

    public function test_uses_config(): void
    {
        static::assertEquals(include(__DIR__.'/../config/nida-client.php'), config('nida-client'));
    }

    public function test_publishes_config(): void
    {
        $this->artisan(
            'vendor:publish',
            [
                '--provider' => 'SoftwareGalaxy\NidaClient\NidaClientServiceProvider',
                '--tag' => 'nida-client-config',
            ]
        )->execute();

        static::assertFileEquals(base_path('config/nida-client.php'), __DIR__.'/../config/nida-client.php');
    }

    protected function tearDown(): void
    {
        $this->filesystem->delete(base_path('config/nida-client.php'));
        $this->filesystem->cleanDirectory(database_path('migrations'));

        parent::tearDown();
    }
}
