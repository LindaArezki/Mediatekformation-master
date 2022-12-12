<?php


namespace App\Tests\Repository;

use App\Entity\Playlist;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of PlaylistRepositoryTest
 *
 * @author linda
 */
class PlaylistRepositoryTest extends KernelTestCase{
    
    /**
     * Réécupère le repository de Playlist
     * @return PlaylistRepository
     */
    public function recupRepository(): PlaylistRepository {
        self::bootKernel();
        $repository = self::getContainer()->get(PlaylistRepository::class);
        return $repository;  
    }

    /**
     * Test le nombre d'enregistrement des playlists
     */
     public function testNbPlaylists() {
       
        $repository = $this->recupRepository();
        $nbPlaylists = $repository->count([]);
        $this->assertEquals(27, $nbPlaylists);
    }
   
    /*
     * Création d'une instance de Playlist
     * @return Playlist
     */
    public function newPlaylist(): Playlist{
        $playlist = (new Playlist())
                ->setName('Playlist pour le test')
                ->setDescription("Description test du test d'intégration");
        return $playlist;
    }
    
    /*
     * Teste l'ajout d'une Playlist
     */

    public function testAddPlaylist(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $nbPlaylists = $repository->count([]);
        $repository->add($playlist, true);
        $this->assertEquals($nbPlaylists + 1, $repository->count([]), "erreur lors de l'ajout");
    }
    
    /*
     * Teste la suppression d'une Playlist
     */
    public function testRemovePlaylist(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist, true);
        $nbPlaylists = $repository->count([]);
        $repository->remove($playlist, true);
        $this->assertEquals($nbPlaylists - 1, $repository->count([]), "erreur lors de la suppression");        
    }

      /**
     * Teste la méthode findAllOrderByName triée sur un ordre
     */
    public function testFindAllOrderbyName(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist, true);
        $playlists = $repository->findAllOrderByName("ASC");
        $nbPlaylists = count($playlists);
        $this->assertEquals(28, $nbPlaylists);
        $this->assertEquals("Bases de la programmation (C#)", $playlists[0]->getName());
    }
    
    /**
     * Teste la méthode findAllOrderByNbForrmation triée sur un ordre
     */
    public function testFindAllOrderbyNbFormations(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist, true);
        $playlists = $repository->findAllOrderByNbFormations("ASC");
        $nbPlaylists = count($playlists);
        $this->assertEquals(28, $nbPlaylists);
        $this->assertEquals("Cours Informatique embarquée", $playlists[1]->getName());
    }
    
    /**
     * Teste la méthode findByContainValue dont un champ qui se trouve dans une autre table contient une valeur
    */
     public function testFindByContainValue(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist, true);
        $playlists = $repository->findByContainValue("name", "Java","categories");
        $nbPlaylists = count($playlists);
        $this->assertEquals(3,$nbPlaylists);
        $this->assertEquals("Eclipse et Java", $playlists[0]->getName());
     }
    
}
