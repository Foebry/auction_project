<?php

    function getParamList(string $query_string): array {

        $list = explode("&", $query_string);
        $params = [];

        foreach($list as $item){

            if($item === "") continue;

            [$key, $value] = explode("=", $item);
            $params[$key] = $value;
        }

        return $params;
    }

    function getAllowedSorts(string $route): array{

        switch ($route){
            case "auctions":
                $allowed_sorts = ["auc_id", "-auc_id", "cat_id", "-cat_id", "auc_art_id", "-auc_art_id", "start", "end", "duration", "-start", "-end", "-duration"];
                break;
            default:
                $allowed_sorts = [];
        }

        return $allowed_sorts;
    }

    function getAllowedFilters(string $route): array{

        switch( $route ){
            case "auctions":
                $allowed_filters = ["cat_id", "auc_art_id", "status"];
                break;
            default:
                $allowed_filters = [];
                break;
        }

        return $allowed_filters;
    }

    function getActiveFilters(string $route, string $query_string): array{

        $params = getParamList($query_string);

        $allowed_filters = getAllowedFilters($route);

        $active_filters = [];

        // indien param een mogelijke filter is, zet bij actieve filters.
        foreach($params as [$key, $value]){
            // [$key, $value] =  explode("=", $param);

            if( in_array($key, $allowed_filters)){
                $active_filters[$key] = $value;
            }
        }
        return $active_filters;
    }

    function getActiveSorts( string $route, string $query_string ): array{

        // verkrijg waarde na sort= tot aan de volgende parameter?
        // ...&sort=-id&page=1... => ["-id"]
        $split = explode("sort=", $query_string);
        if( count($split) === 1) return [];
        $sorts = explode(",", $split[1]);

        $allowed_sorts = getAllowedSorts($route);

        $active_sorts = [];

        // indien param een mogelijke filter is, zet bij actieve filters.
        foreach($sorts as $sort){
            if( in_array($sort, $allowed_sorts)){
                $active_sorts[] = $sort;
            }
        }
        return $active_sorts;
    }

    function getJoinsNeeded(string $route, string $query_string, $default_joins=[]): array {

        $joins = $default_joins;

        $filters = getActiveFilters($route, $query_string);
        $sorts = getActiveSorts($route, $query_string);
        switch( $route ){
            case "auctions":
                if( in_array("cat_id", array_keys($filters))){
                    if( !in_array("gw_article", array_keys($joins)) ) $joins["gw_article"] = ["auc_art_id", "art_id"];
                    if( !in_array("gw_category", array_keys($joins)) ) $joins["gw_category"] = ["art_cat_id", "cat_id"];
                }
                if( in_array("cat_id", $sorts) || in_array("-cat_id", $sorts) ){
                    if( !in_array("gw_article", array_keys($joins)) ) $joins["gw_article"] = ["auc_art_id", "art_id"];
                    if( !in_array("gw_category", array_keys($joins)) ) $joins["gw_category"] = ["art_cat_id", "cat_id"];
                }
        }

        return $joins;
    }

    function translateActiveFilters(array $active_filters): string {
        
        if( count($active_filters) === 0 ) return "";
        $filters = [];

        $where = "where ";

        foreach($active_filters as $key => $value){
            if( $key !== "status" ){
                $filters[] = "$key in ($value)";
                continue;
            }
            switch( $value ){
                case "0":
                    $filters[] = "auc_start > now() + interval 1 hour";
                    break;
                case "1":
                    $filters[] = "auc_start < now() + interval 1 hour and auc_expiration > now() + interval 1 hour";
                    break;
                case "-1":
                    $filters[] = 'auc_expiration < now() + interval 1 hour';
                    break;
                default:
                    break;
            }    
        }

        return $where.implode(" and ", $filters);
        
    }

    function translateActiveSorts(array $active_sorts): string {

        if( count($active_sorts) === 0 ) return "";

        $order = "order by ";
        $sorts = [];

        foreach($active_sorts as $sort){

            if( in_array($sort, ["start", "end", "-start", "-end"])){
                switch($sort){
                    case "start":
                        $sort = "auc_start";
                        break;
                    case "-start":
                        $sort = "-auc_start";
                        break;
                    case "end":
                        $sort = "auc_expiration";
                        break;
                    case "-end":
                        $sort = "-auc_expiration";
                        break;
                    default: break;
                }
            }

            $exploded = explode("-", $sort);

            if( count($exploded) === 1 ) $sorts[] = $exploded[0];
            else $sorts[] = $exploded[1]." desc";
        }

        return $order.implode(", ", $sorts);
    }

    function translateJoins(array $join_tables): string {
        $join = "";

        foreach($join_tables as $table => [$pkey, $fkey]){
            $join.= "join $table on $pkey = $fkey\n";
        }

        return $join;
    }

    function getPageLimit(string $query_string): string {

        $params = getParamList($query_string);

        foreach($params as $key => $value){
            if( $key == "page_count") return "limit $value";
        }

        return "";
    }

    function getOffset(string $query_string, $total): array {

        $params = getParamList($query_string);

        foreach($params as $key => $value){
            if( $key == "page") {
                $page_count = $params["page_count"];

                $offset = min(($value -1) * $page_count, floor($total / $page_count) * $page_count);
                $page = $offset / $page_count + 1;

                return ["offset ".$offset, $page];
            }
        }

        return ["", 1];
    }

    function processParams(string $route, string $query_string, $default_joins): array {

        $active_filters = getActiveFilters($route, $query_string);
        $active_sorts = getActiveSorts($route, $query_string);
        $join_tables = getJoinsNeeded($route, $query_string, $default_joins);

        $where = translateActiveFilters($active_filters);
        $sort = translateActiveSorts($active_sorts);
        $join = translateJoins($join_tables);

        return[$join, $where, $sort];
    }
