update REQUESTS set status='expired' where status='pending' and date_sub(now(), interval 15 minute) > req_time;
