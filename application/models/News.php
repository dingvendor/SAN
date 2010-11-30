<?php
require_once('markdown.php');

class models_News {

	public function getHeadlines($limit = 5)
	{
		$db = Zend_Registry::get('db');

		$stmt = $db->query("SELECT n.id, n.title, n.content, n.summary, n.postdate, n.moddate, n.logo, a.username AS author, UNIX_TIMESTAMP(n.postdate) AS postdate_unixtimestamp,  UNIX_TIMESTAMP(n.moddate) AS moddate_unixtimestamp
                                    FROM news AS n
                                    LEFT JOIN account AS a ON a.id=n.author
                                    WHERE n.status='published'
				    ORDER BY n.postdate DESC LIMIT ?", $limit);
		
		$results = $stmt->fetchAll();
		
			
		foreach($results as $result)
		{
			$result['content_markdown'] = Markdown($result['content']);
			// var_dump($result);
			$headlines[] = $result;
			// echo "<hr>";
		}

		return $headlines;
	}

	public function getArticleById($id)
	{
		 $db = Zend_Registry::get('db');

                $stmt = $db->query("SELECT n.id, n.title, n.content, n.summary, n.postdate, n.logo, a.username AS author
                                    FROM news AS n
				    LEFT JOIN account AS a ON a.id=n.author
                                    WHERE n.status='published' AND n.id=?", $id);

                $result = $stmt->fetch();
		// var_dump($result);
		$result['content_markdown'] = Markdown($result['content']);
		return $result;
	}
}
