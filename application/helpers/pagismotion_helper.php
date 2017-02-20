<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(!function_exists('pagismotion')){
    function pagismotion($page = 1, $per_page = 10, $row = 0){
    	$total = $row;
        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
        if ($lastpage > 1) {
            $pagination .= "<ul class='pagination pagination-sm'>";
            $pagination .= "<li><a>Page $page of $lastpage</a></li>";
            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page){
                        $pagination.= "<li class='active'><a>$counter</a></li>";
                    }else{
                        $pagination.= "<li><a href='$counter'>$counter</a></li>";
                    }
                }
            }
            elseif ($lastpage > 5 + ($adjacents * 2)) {
                if ($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page){
                            $pagination.= "<li class='active'><a class='active'>$counter</a></li>";
                        }else{
                            $pagination.= "<li><a href='$counter'>$counter</a></li>";
                        }
                    }
                    $pagination.= "<li class='dot'><a>...</a></li>";
                    $pagination.= "<li><a href='$lpm1'>$lpm1</a></li>";
                    $pagination.= "<li><a href='$lastpage'>$lastpage</a></li>";
                }
                elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination.= "<li><a href='1'>1</a></li>";
                    $pagination.= "<li><a href='2'>2</a></li>";
                    $pagination.= "<li class='dot'><a>...</a></li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<li class='active'><a class='active'>$counter</a></li>";
                        else
                            $pagination.= "<li><a href='$counter'>$counter</a></li>";
                    }
                    $pagination.= "<li class='dot'><a>...</a></li>";
                    $pagination.= "<li><a href='$lpm1'>$lpm1</a></li>";
                    $pagination.= "<li><a href='$lastpage'>$lastpage</a></li>";
                }
                else {
                    $pagination.= "<li><a href='1'>1</a></li>";
                    $pagination.= "<li><a href='2'>2</a></li>";
                    $pagination.= "<li class='dot'><a>...</a></li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page)
                            $pagination.= "<li class='active'><a class='active'>$counter</a></li>";
                        else
                            $pagination.= "<li><a href='$counter'>$counter</a></li>";
                    }
                }
            }

            if ($page < $counter - 1) {
                $pagination.= "<li><a href='$next'>Next</a></li>";
                $pagination.= "<li><a href='$lastpage'>Last</a></li>";
            } else {
                $pagination.= "<li><a class='current'>Next</a></li>";
                $pagination.= "<li><a class='current'>Last</a></li>";
            }
            $pagination.= "</ul>\n";
        }
        return $pagination;
    }
}