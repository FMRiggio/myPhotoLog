<?php
//
//  Copyright (c) 2009 Facebook
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to interface writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//

//
// This file defines the interface iXHProfRuns and also provides a default
// implementation of the interface (class XHProfRuns).
//

/**
 * iXHProfRuns interface for getting/saving a XHProf run.
 *
 * Clients can either use the default implementation,
 * namely XHProfRuns_Default, of this interface or define
 * their own implementation.
 *
 * @author Kannan
 */
interface iXHProfRuns {

  /**
   * Returns XHProf data given a run id ($run) of a given
   * type ($type).
   *
   * Also, a brief description of the run is returned via the
   * $run_desc out parameter.
   */
  public function get_run($run_id, $type, &$run_desc);

  /**
   * Save XHProf data for a profiler run of specified type
   * ($type).
   *
   * The caller may optionally pass in run_id (which they
   * promise to be unique). If a run_id is not passed in,
   * the implementation of this method must generated a
   * unique run id for this saved XHProf run.
   *
   * Returns the run id for the saved XHProf run.
   *
   */
  public function save_run($xhprof_data, $type, $run_id = null);
}


/**
 * XHProfRuns_Default is the default implementation of the
 * iXHProfRuns interface for saving/fetching XHProf runs.
 *
 * This modified version of the file uses a MySQL backend to store
 * the data, it also stores additional information outside the run
 * itself (beyond simply the run id) to make comparisons and run
 * location easier
 * 
 * Configuration steps:
 *  1 - Set the database credentials in the class properties
 *  2 - Create the database, create table syntax provided below
 *  3 - Set the prefix for this server or application
 *  4 - Configure the urlSimilator method (bottom of this file)
 *  5 - Ensure you're using the callgraph_utils.php and xprof_runs.php 
 * files from this repo, as they've been updated to deal with get_run() returning
 * an array.
 *
 * @author Kannan
 * @author Paul Reinheimer (http://blog.preinheimer.com)
 */
class XHProfRuns_Default implements iXHProfRuns {

  private $dir = '';
  public $prefix = 't11_';
  public $run_details = null;
  protected $linkID;

  public function __construct($dir = null) 
  {
    $this->db();
  }

  protected function db()
  {
	global $_xhprof;
	$connectionInfo = array("UID" => $_xhprof['dbuser'], "PWD" =>  $_xhprof['dbpass'], "Database"=>$_xhprof['dbname'], "ReturnDatesAsStrings" => TRUE);
    $linkid = sqlsrv_connect($_xhprof['dbhost'], $connectionInfo);
    if ($linkid === FALSE)
    {
      xhprof_error("Could not connect to db");
      $run_desc = "could not connect to db";
      throw new Exception("Unable to connect to database");
      return false;
    }
    $this->linkID = $linkid; 
  }
  /**
  * When setting the `id` column, consider the length of the prefix you're specifying in $this->prefix
  * 
  *
CREATE TABLE dbo.details
(
   id nchar(17) NOT NULL, 
   url nvarchar(255) NULL DEFAULT NULL, 
   c_url nvarchar(255) NULL DEFAULT NULL, 
   timestamp datetime NOT NULL DEFAULT getdate(), 
   [server name] nvarchar(64) NULL DEFAULT NULL, 
   perfdata nvarchar(max) NULL, 
   type smallint NULL DEFAULT NULL, 
   cookie nvarchar(max) NULL, 
   post nvarchar(max) NULL, 
   get nvarchar(max) NULL, 
   pmu int NULL DEFAULT NULL, 
   wt int NULL DEFAULT NULL, 
   cpu int NULL DEFAULT NULL, 
   server_id nchar(3) NOT NULL DEFAULT N't11', 
   CONSTRAINT PK_details_id PRIMARY KEY (id)
)
GO
CREATE NONCLUSTERED INDEX dbo.url
   ON dbo.details (url ASC)
GO
CREATE NONCLUSTERED INDEX dbo.c_url
   ON dbo.details (c_url ASC)
GO
CREATE NONCLUSTERED INDEX dbo.cpu
   ON dbo.details (cpu ASC)
GO
CREATE NONCLUSTERED INDEX dbo.wt
   ON dbo.details (wt ASC)
GO
CREATE NONCLUSTERED INDEX dbo.pmu
   ON dbo.details (pmu ASC)
GO
CREATE NONCLUSTERED INDEX dbo.timestamp
   ON dbo.details (timestamp
  
*/

    
  private function gen_run_id($type) 
  {
    return uniqid();
  }
  
  /**
  * This function gets runs based on passed parameters, column data as key, value as the value. Values
  * are escaped automatically. You may also pass limit, order by, group by, or "where" to add those values,
  * all of which are used as is, no escaping. 
  * 
  * @param array $stats Criteria by which to select columns
  * @return resource
  */
  public function getRuns($stats)
  {
  
      if (isset($stats['limit']))
      {
          $query = "SELECT TOP {$stats['limit']} ";
      }else
      {
		$query = "SELECT ";
      }
      
      
      if (isset($stats['select']))
      {
        $query .= "{$stats['select']} FROM [details] ";  
      }else
      {
        $query .= "* FROM [details] ";
      }
      
      $skippers = array("limit", "order by", "group by", "where", "select");
      $hasWhere = false;
      
      foreach($stats AS $column => $value)
      {
          
          if (in_array($column, $skippers))
          {
              continue;
          }
          if ($hasWhere === false)
          {
              $query .= " WHERE ";
              $hasWhere = true;
          }elseif($hasWhere === true)
          {
            $query .= "AND ";
          }
          if (strlen($value) == 0)
          {
              $query .= $column;
          }
          $value = addslashes($value);
          $query .= " [$column] = '$value' ";
      }
      
      if (isset($stats['where']))
      {
          if ($hasWhere === false)
          {
              $query .= " WHERE ";
              $hasWhere = true;
          }else
          {
            $query .= " AND ";
          }
          $query .= $stats['where'];
      }
      
      if (isset($stats['group by']))
      {
          $query .= " GROUP BY [{$stats['group by']}] ";
      }
      
      if (isset($stats['order by']))
      {
          $query .= " ORDER BY [{$stats['order by']}] DESC";
      }

      
      $resultSet = sqlsrv_query($this->linkID, $query);
      if (!$resultSet)
      {
		echo "Failed: <b>$query</b>";
	  }
      //echo "ran $query";
      //var_dump($resultSet);
      return $resultSet;
  }
  
  /**
   * Obtains the pages that have been the hardest hit over the past N days, utalizing the getRuns() method.
   *
   * @param array $criteria An associative array containing, at minimum, type, days, and limit
   * @return resource The result set reprsenting the results of the query
   */
  public function getHardHit($criteria)
  {
    //call thing to get runs
    $criteria['select'] = "([{$criteria['type']}]), count([{$criteria['type']}]) AS 'count' , sum([wt]) as total_wall, avg([wt]) as avg_wall";
    unset($criteria['type']);
    
    $criteria['where'] = "dateadd(d, -{$criteria['days']}, getdate()) <= details.timestamp";
    unset($criteria['days']);
    $criteria['group by'] = "url";
    $criteria['order by'] = "count";
    $resultSet = $this->getRuns($criteria);
    
    return $resultSet;
  }
  
  public function getDistinct($data)
  {
	$sql['column'] = addslashes($data['column']);
	$query = "SELECT DISTINCT([{$sql['column']}]) FROM [details]";
	$rs = sqlsrv_query($this->linkID, $query);
	return $rs;
  }
  
  public static function getNextAssoc($resultSet)
  {
  //var_dump($resultSet);
  $a = sqlsrv_fetch_array($resultSet, SQLSRV_FETCH_ASSOC);
  //var_dump($a);
    return $a;
  }
  
  /**
  * Retreives a run from the database, 
  * 
  * @param string $run_id unique identifier for the run being requested
  * @param mixed $type
  * @param mixed $run_desc
  * @return mixed
  */
  public function get_run($run_id, $type, &$run_desc) 
  {
    $run_id = addslashes($run_id);
    $query = "SELECT * FROM [details] WHERE [id] = '$run_id'";
    $resultSet = sqlsrv_query($this->linkID, $query);
    $data = sqlsrv_fetch_array($resultSet, SQLSRV_FETCH_ASSOC);
    
    //The Performance data is compressed lightly to avoid max row length
    $contents = unserialize(gzuncompress($data['perfdata']));
    
    //This data isnt' needed for display purposes, there's no point in keeping it in this array
    unset($data['perfdata']);


    // The same function is called twice when diff'ing runs. In this case we'll populate the global scope with an array
    if (is_null($this->run_details))
    {
        $this->run_details = $data;
    }else
    {
        $this->run_details[0] = $this->run_details; 
        $this->run_details[1] = $data;
    }
    
    $run_desc = "XHProf Run (Namespace=$type)";
    $this->getRunComparativeData($data['url'], $data['c_url']);
    
    return array($contents, $data);
  }
  
  /**
  * Get stats (pmu, ct, wt) on a url or c_url
  * 
  * @param array $data An associative array containing the limit you'd like to set for the queyr, as well as either c_url or url for the desired element. 
  * @return resource result set from the database query
  */
  public function getUrlStats($data)
  {
      $data['select'] = '[id], DATEDIFF(s, \'1970-01-01 00:00:00\', [timestamp]) as [timestamp], [pmu], [wt], [cpu]';   
      $rs = $this->getRuns($data);
      return $rs;
  }
  
  /**
  * Get comparative information for a given URL and c_url, this information will be used to display stats like how many calls a URL has,
  * average, min, max execution time, etc. This information is pushed into the global namespace, which is horribly hacky. 
  * 
  * @param string $url
  * @param string $c_url
  * @return array
  */
  public function getRunComparativeData($url, $c_url)
  {
      $url = addslashes($url);
      $c_url = addslashes($c_url);
      //Runs same URL
      //  count, avg/min/max for wt, cpu, pmu
      $query = "SELECT count([id]) as 'count(`id`)', avg([wt]) as 'avg(`wt`)', min([wt]) as 'min(`wt`)', max([wt]) as 'max(`wt`)', avg([cpu]) as 'avg(`cpu`)', min([cpu]) as 'min(`cpu`)', max([cpu]) as 'max(`cpu`)', avg([pmu]) as 'avg(`pmu`)', min([pmu]) as 'min(`pmu`)', max([pmu]) as 'max(`pmu`)'  FROM [details] WHERE [url] = '$url'";
      $rs = sqlsrv_query($this->linkID, $query);
      $row = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);
      $row['url'] = $url;
      
      $row['95(`wt`)'] = $this->calculatePercentile(array('count' => $row['count(`id`)'], 'column' => 'wt', 'type' => 'url', 'url' => $url));
      $row['95(`cpu`)'] = $this->calculatePercentile(array('count' => $row['count(`id`)'], 'column' => 'cpu', 'type' => 'url', 'url' => $url));
      $row['95(`pmu`)'] = $this->calculatePercentile(array('count' => $row['count(`id`)'], 'column' => 'pmu', 'type' => 'url', 'url' => $url));

      global $comparative;
      
      $comparative['url'] = $row;
      unset($row);
      
      //Runs same c_url
      //  count, avg/min/max for wt, cpu, pmu
      $query = "SELECT count([id]) as 'count(`id`)', avg([wt]) as 'avg(`wt`)', min([wt]) as 'min(`wt`)', max([wt]) as 'max(`wt`)', avg([cpu]) as 'avg(`cpu`)', min([cpu]) as 'min(`cpu`)', max([cpu]) as 'max(`cpu`)', avg([pmu]) as 'avg(`pmu`)', min([pmu]) as 'min(`pmu`)', max([pmu]) as 'max(`pmu`)' FROM [details] WHERE [c_url] = '$c_url'";
     
     
      $rs = sqlsrv_query($this->linkID, $query);
      
      $row = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);
      $row['url'] = $c_url;
      
      $row['95(`wt`)'] = $this->calculatePercentile(array('count' => $row['count(`id`)'], 'column' => 'wt', 'type' => 'c_url', 'url' => $c_url));
      $row['95(`cpu`)'] = $this->calculatePercentile(array('count' => $row['count(`id`)'], 'column' => 'cpu', 'type' => 'c_url', 'url' => $c_url));
      $row['95(`pmu`)'] = $this->calculatePercentile(array('count' => $row['count(`id`)'], 'column' => 'pmu', 'type' => 'c_url', 'url' => $c_url));

      $comparative['c_url'] = $row;
      unset($row);
      return $comparative;
  }
  
  protected function calculatePercentile($details)
  {
                  $limit = (int) ($details['count'] / 20);
                  //TODO Put the limit stuff back LIMIT $limit, 1
                  $query = "SELECT [{$details['column']}] as [value] FROM [details] WHERE [{$details['type']}] = '{$details['url']}' ORDER BY [{$details['column']}] DESC";
                  $rs = sqlsrv_query($this->linkID, $query);
                  $row = sqlsrv_fetch_array($rs, SQLSRV_FETCH_ASSOC);
                  return $row['value'];
  }
  
  /**
  * Save the run in the database. 
  * 
  * @param string $xhprof_data
  * @param mixed $type
  * @param string $run_id
  * @param mixed $xhprof_details
  * @return string
  */
    public function save_run($xhprof_data, $type, $run_id = null, $xhprof_details = null) 
    {
        global $_xhprof;

		$sql = array();
        if ($run_id === null) {
          $run_id = $this->gen_run_id($type);
        }
        
		/*
		Session data is ommitted purposefully, mostly because it's not likely that the data
		that resides in $_SESSION at this point is the same as the data that the application
		started off with (for most apps, it's likely that session data is manipulated on most
		pageloads).
		
		The goal of storing get, post and cookie is to help explain why an application chose
		a particular code execution path, pehaps it was a poorly filled out form, or a cookie that
		overwrote some default parameters. So having them helps. Most applications don't push data
		back into those super globals, so we're safe(ish) storing them now. 
		
		We can't just clone the session data in header.php to be sneaky either, starting the session
		is an application decision, and we don't want to go starting sessions where none are needed
		(not good performance wise). We could be extra sneaky and do something like:
		if(isset($_COOKIE['phpsessid']))
		{
			session_start();
			$_xhprof['session_data'] = $_SESSION;
		} 
		but starting session support really feels like an application level decision, not one that
		a supposedly unobtrusive profiler makes for you. 
		
		*/

        $sql['get'] = addslashes(serialize($_GET));
        $sql['cookie'] = addslashes(serialize($_COOKIE));
        
        //This code has not been tested
        if ($_xhprof['savepost'])
        {
        	$sql['post'] = addslashes(serialize($_POST));    
        }else
        {
        	$sql['post'] = addslashes(serialize(array("Skipped" => "Post data omitted by rule")));
        }
        
        
	$sql['pmu'] = isset($xhprof_data['main()']['pmu']) ? $xhprof_data['main()']['pmu'] : '';
 	$sql['wt']  = isset($xhprof_data['main()']['wt'])  ? $xhprof_data['main()']['wt']  : '';
	$sql['cpu'] = isset($xhprof_data['main()']['cpu']) ? $xhprof_data['main()']['cpu'] : '';        


        //The MyISAM table type has a maxmimum row length of 65,535bytes, without compression XHProf data can exceed that. 
		// The value of 2 seems to be light enugh that we're not killing the server, but still gives us lots of breathing room on 
		// full production code. 
        $sql['data'] = gzcompress(serialize($xhprof_data), 2);
        
	$url   = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF'];
 	$sname = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
	
        $sql['url'] = $url;
        $sql['c_url'] = _urlSimilartor($_SERVER['REQUEST_URI']);
        $sql['servername'] = $sname;
        $sql['type']  = (int) (isset($xhprof_details['type']) ? $xhprof_details['type'] : 0);
        $sql['timestamp'] = addslashes(date('c', $_SERVER['REQUEST_TIME']));
		$sql['server_id'] = addslashes($_xhprof['servername']);
        
        
        $query = "INSERT INTO [details] ([id], [url], [c_url], [timestamp], [server name], [perfdata], [type], [cookie], [post], [get], [pmu], [wt], [cpu], [server_id]) 
        VALUES(?, ?, ?, ?, ?,?, ?, ?, ?, ?,?,?,?,?)";
        $params = array(&$run_id, &$sql['url'], &$sql['c_url'], &$sql['timestamp'], &$sql['servername'], &$sql['data'], &$sql['type'], &$sql['cookie'], &$sql['post'], &$sql['get'], &$sql['pmu'], &$sql['wt'], &$sql['cpu'], &$sql['server_id']);
        

        $stmt = sqlsrv_prepare($this->linkID, $query, $params);
        if ($stmt)
        {
			sqlsrv_execute($stmt);
            return $run_id;
        }else
        {
            global $_xhprof;
            if ($_xhprof['display'] === true)
            {
                echo "Failed to insert: $query <br>\n";
                var_dump(sqlsrv_errors());
            }
            return -1;
        }
  }
  
  

}
