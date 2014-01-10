<?php
include_once(dirname(dirname(dirname(__FILE__))) . '/classes/generic.class.php');

class Agency_feeds extends Generic {

    public $latest_feed_id = 0;

	public function __construct()
    {
        parent::__construct();
    }

    public function add($type, $feed, $label, $url) {
	  $user = $_SESSION['nware']['username'];
      $params = array( ':by' => $user, ':type' => $type, ':feed' => $feed, ':label' => $label, ':url' => $url );

	  parent::query("INSERT INTO `agency_feed` (`by`, `type`, `feed`, `label`, `url`)
						   VALUES (:by, :type, :feed, :label, :url)", $params);
    }

    public function display()
    {
        $query = parent::query("SELECT * FROM agency_feed ORDER BY stamp DESC");
        if ($query->rowCount() > 0) {
            $feeds = $query->fetchAll(PDO::FETCH_ASSOC);
            $this->latest_feed_id = $feeds[0]['id'];
            echo $this->generateFeeds($feeds);
        }
    }

    public function getLatest($after_feed)
    {
        $query = parent::query("SELECT * FROM agency_feed WHERE id > :id ORDER BY stamp DESC", array(':id' => $after_feed));
        if ($query->rowCount() > 0) {
            $feeds = $query->fetchAll(PDO::FETCH_ASSOC);
            $this->latest_feed_id = $feeds[0]['id'];
            return $this->generateFeeds($feeds, 'hide');
        } else {
            $this->latest_feed_id = $after_feed;
            return '';
        }
    }

    private function generateFeeds($feeds, $tr_class = '')
    {
        $data = '';
        foreach ($feeds as $feed) {
            $data .= '<tr class="' . $tr_class . '">
                        <td><span class="label label-success"><i class="icon-user"></i></span> ' . $feed['by'] . ' ' .
                            $feed['feed'] . ' <a href="' . $feed['url'] . '">' . $feed['label'] . '</a></td>
                      </tr>' . PHP_EOL;
        }
        return $data;
    }
}

$feeds = new Agency_feeds();