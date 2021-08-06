<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        //creer 3 category
        for ($i=1; $i <=3 ; $i++) { 
            $category= new Category();
            $category->setTitle($faker->sentence())
                      ->setDescription($faker->paragraph());
          
         $manager->persist($category);
                    
        
     //creer entre 4 et 6 articles
        for ($j = 1; $j <= mt_rand(4 ,6); ++$j) {
            $article = new Article();
            $content ='<p> '. join($faker->paragraphs(5),'</p><p>').'</p>';

            $article->setTitle($faker->sentence())
            ->setContent($content)
            ->setImage($faker->imageUrl())
            ->setCreatedAt($faker->dateTimeBetween('-6 months'))
            ->setCategory($category);

            $manager->persist($article);


             //creer entre 4 et 6 articles
            for ($k = 1; $k <= mt_rand(5 ,8); ++$k) {
            $comment = new Comment();
            $content ='<p> '. join($faker->paragraphs(2),'</p> <p>').'</p>';

           
            $days =(new \DateTime())->diff($article->getCreatedAt())->days;
    
            $comment->setAuthor($faker->sentence());
            $comment->setContent($content);
            $comment->setCreatedAt($faker->dateTimeBetween('-'. $days . 'days'))->setArticle($article);
                    $manager->persist($comment);
          }
        }
      }

        $manager->flush();
    }
}
