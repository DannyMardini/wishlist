<?php

class Time
{
    public static function getFormattedTimestamp($strDateTime)
    {
        //$submittedDateTime = strtotime($this->getDatetime());
        $dateTime = strtotime($strDateTime);
        $thisYear = date('Y') == date('Y', $dateTime);

        if ( $thisYear > 0 )
        {
            $thisWeek = date('W') == date('W', $dateTime);
            if( $thisWeek > 0 )
            {
                $yesterday = date('j', $dateTime) == (date('j')-1);
                $today = date('j') == date('j', $dateTime);

                if( $yesterday > 0 )
                {
                    return " Yesterday @ ".date("g:i a", $dateTime);
                }
                else if( $today > 0 )
                {
                    return "Today @".date(" g:i a", $dateTime);
                }
                else
                {
                    return date(  "l \@ g:i a", $dateTime);
                }
            }
            else
            {
                return date(  "F jS \@ g:i a", $dateTime);
            }
        }
        else
        {
            $seconds = time() - $dateTime;
            $days = round($seconds / (24*60*60));

            $yesterday = $days <= 1;
            $thisWeek = (round($days / 7)) <= 1;

            if($yesterday > 0)
            {
                return " yesterday @ ".date("g:i a", $dateTime);
            }
            else if($thisWeek > 0)
            {
                return date(  "l \@ g:i a", $dateTime);
            }
            else
            {
                return date(  "F jS, Y, g:i a", $dateTime);
            }
        }
    }
}
?>
