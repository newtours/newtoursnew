<?php

namespace Drupal\tours\TwigExtension;

use Drupal\Core\Render\Renderer;

/**
 * Class DefaultTwigExtension.
 *
 * @package Drupal\tours
 */
class DefaultTwigExtension extends \Twig_Extension {

        
   /**
    * {@inheritdoc}
    */
    public function getTokenParsers() {
      return [];
    }

   /**
    * {@inheritdoc}
    */
    public function getNodeVisitors() {
      return [];
    }

   /**
    * {@inheritdoc}
    */
    public function getFilters() {
      return [];
    }

   /**
    * {@inheritdoc}
    */
    public function getTests() {
      return [];
    }

   /**
    * {@inheritdoc}
    */
    public function getFunctions() {
      return [];
    }

   /**
    * {@inheritdoc}
    */
    public function getOperators() {
      return [];
    }

   /**
    * {@inheritdoc}
    */
    public function getName() {
      return 'tours.twig.extension';
    }

}
