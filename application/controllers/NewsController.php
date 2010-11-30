<?php

class NewsController extends Zend_Controller_Action
{
	private $_news;
    public function init()
    {
        /* Initialize action controller here */
	$this->_news = new models_News();

	$this->view->headTitle()->append('News');
    }

    public function indexAction()
    {
	$this->view->headlines = $this->_news->getHeadlines(10);
    }

	public function articleAction()
	{
		$id = $this->_getParam('id');
		
		$filter = new Zend_Filter_Int();
		
		$cleanId = $filter->filter($id);

		$result = $this->_news->getArticleById($cleanId);

		$this->view->article = $result;

		$this->view->headTitle()->append($result['title']);
	}
	
	public function submitAction()
        {
            // Allow those who are logged in to submit news
        }

	public function feedAction()
	{

		$this->getHelper('layout')->disableLayout();
	        $this->getHelper('viewRenderer')->setNoRender();

		$config = Zend_Registry::get('config');

                /**
                 * @TODO Move this code to a model
                 */
		/**
		 * Create the parent feed
		 */	
		$feed = new Zend_Feed_Writer_Feed;
		$feed->setTitle('Task Force 93 News');
		$feed->setLink('http://www.arkroyal.org/');
		$feed->setDescription('News from around Task Force 93');
		$feed->setFeedLink('http://www.arkroyal.org/news/feed', 'rss');
		$feed->addAuthor(array(
		    'name'  => 'Dan',
		    'email' => 'news@arkroyal.org',
		    'uri'   => 'http://www.arkroyal.org',
		));
		$feed->setDateModified(time());
		// $feed->addHub('http://pubsubhubbub.appspot.com/');
 
		/**
		 * Add one or more entries. Note that entries must
		 * be manually added once created.
		 */	
		$news = new models_News();
		foreach($news->getHeadlines(20) as $article)
		{
		//var_dump($article);
		//die("we're done");
		$entry = $feed->createEntry();
		$entry->setTitle($article['title']);
		$entry->setLink($config->domain.'/news/article/id/'.$article['id']);
		$entry->addAuthor(array(
		    'name'  => 'Dan',
		    'email' => 'news@taskforce93.com',
		    'uri'   => 'http://www.taskforce93.com',
		));
		$entry->setDateModified($article['moddate_unixtimestamp']);
		$entry->setDateCreated($article['postdate_unixtimestamp']);
		$entry->setDescription($article['summary']);
		$entry->setContent($article['content_markdown']);
		$feed->addEntry($entry);
		}

		/**
		 * Render the resulting feed to Atom 1.0 and assign to $out.
		 * You can substitute "atom" with "rss" to generate an RSS 2.0 feed.
		 */
		echo $feed->export('rss');
	}

        
}

