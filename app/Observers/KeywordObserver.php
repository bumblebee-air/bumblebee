<?php

namespace App\Observers;

use App\Keyword;
//use Elasticquent\ElasticquentTrait;

class KeywordObserver
{
  //use ElasticquentTrait;

  /**
   * Handle the keyword "created" event.
   *
   * @param  \App\Keyword  $keyword
   * @return void
   */
  public function created(Keyword $keyword)
  {
    \Log::info("Keyword added in Elasticsearch successfully!", [
      'id' => $keyword->id
    ]);

    //$keyword->addToIndex();
  }

  /**
   * Handle the keyword "updated" event.
   *
   * @param  \App\Keyword  $keyword
   * @return void
   */
  public function updated(Keyword $keyword)
  {
    //$keyword->updateIndex();
  }

  /**
   * Handle the keyword "deleted" event.
   *
   * @param  \App\Keyword  $keyword
   * @return void
   */
  public function deleted(Keyword $keyword)
  {
    //$keyword->removeFromIndex();
  }
}
