<?php

namespace App\Test\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AnnonceControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AnnonceRepository $repository;
    private string $path = '/annonce/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Annonce::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Annonce index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'annonce[title]' => 'Testing',
            'annonce[description]' => 'Testing',
            'annonce[price]' => 'Testing',
            'annonce[image]' => 'Testing',
            'annonce[PEGI]' => 'Testing',
            'annonce[user]' => 'Testing',
            'annonce[status]' => 'Testing',
        ]);

        self::assertResponseRedirects('/annonce/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Annonce();
        $fixture->setTitle('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPrice('My Title');
        $fixture->setImage('My Title');
        $fixture->setPEGI('My Title');
        $fixture->setUser('My Title');
        $fixture->setStatus('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Annonce');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Annonce();
        $fixture->setTitle('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPrice('My Title');
        $fixture->setImage('My Title');
        $fixture->setPEGI('My Title');
        $fixture->setUser('My Title');
        $fixture->setStatus('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'annonce[title]' => 'Something New',
            'annonce[description]' => 'Something New',
            'annonce[price]' => 'Something New',
            'annonce[image]' => 'Something New',
            'annonce[PEGI]' => 'Something New',
            'annonce[user]' => 'Something New',
            'annonce[status]' => 'Something New',
        ]);

        self::assertResponseRedirects('/annonce/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getPrice());
        self::assertSame('Something New', $fixture[0]->getImage());
        self::assertSame('Something New', $fixture[0]->getPEGI());
        self::assertSame('Something New', $fixture[0]->getUser());
        self::assertSame('Something New', $fixture[0]->getStatus());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Annonce();
        $fixture->setTitle('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPrice('My Title');
        $fixture->setImage('My Title');
        $fixture->setPEGI('My Title');
        $fixture->setUser('My Title');
        $fixture->setStatus('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/annonce/');
    }
}
