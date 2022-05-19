<?php
function requests_per_second($rrt_avg,$cno=1)
{
	$max_req=(float)$cno/$rrt_avg;
	return $max_req;
}
function number_simultaneous($max_req,$clk)
{
	$sim_cust=$max_req*60*$clk;
	return 	$sim_cust;
}
function vcpu_calc($lt,$sim_cust,$clk)
{
	$vcpu=(($sim_cust/60)/$clk)*$lt;
	return($vcpu);
}
$rrt=$_POST["rrt"];
$uclk=$_POST["uclk"];
$page_load=$_POST["tl"];
/*trouble here is that all three functions depend on the outputs of each other 
so I have taken one of them number of CPU cores with a default value of 1 as a starting point*/
$rps=requests_per_second($rrt);
echo"Requests per second assuming one CPU is".$rps."<br>";
//calculating the number of user requests per second
$cust_sim=number_simultaneous($rps, $uclk);
echo"maximum number of simultaneous users assuming one CPU is".$cust_sim."<br>";
//now, we shall be calculating the max number of VCPUs using the number of simultaneous users & requests per second
$vcpu=vcpu_calc($page_load,$cust_sim, $uclk);
echo("Using previously obtained value of number of user requests and user click action taken as input to obtain the number of CPU cores needed:");
echo($vcpu."<br>");
$r=requests_per_second($rrt,$vcpu);
echo"the max number of requests using this number of CPUs is ".$r."<br>";
$sim_cust=number_simultaneous($r, $uclk);
echo"maximum number of simultaneous users using the max number of requests is ".$sim_cust."<br>";
?>