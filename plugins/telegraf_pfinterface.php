#!/usr/local/bin/php-cgi -f
<?php
require_once("config.inc");
require_once("gwlb.inc");
require_once("interfaces.inc");

$host = gethostname();
$source = "pfconfig";

$iflist = get_configured_interface_with_descr(true);
foreach ($iflist as $ifname => $friendly) {
        $ifinfo =  get_interface_info($ifname);
        $ifstatus = $ifinfo['status'];
        $ifconf = $config['interfaces'][$ifname];
        $ipaddr = get_interface_ip($ifname);
        $subnet = get_interface_subnet($ifname);
        $ipaddr6 = get_interface_ipv6($ifname);
        $subnet6 = get_interface_subnetv6($ifname);
        $realif = get_real_interface($ifname);
        $mac = get_interface_mac($realif);

        if (!isset($ipaddr)){
                $ipaddr = "Unassigned";
        }
        if (!isset($mac)){
                $mac = "Unavailable";
        }
        if (strtolower($ifstatus) == "up"){
                $ifstatus = 1;
        }
        if (strtolower($ifstatus) == "active"){
                $ifstatus = 1;
        }
        if (strtolower($ifstatus) == "no carrier"){
                $ifstatus = 0;
        }
        if (strtolower($ifstatus) == "down"){
                $ifstatus = 0;
        }
        if (!isset($ifstatus)){
                $ifstatus = 2;
        }   

        printf("interface,host=%s,name=%s,ip_address=%s,mac_address=%s,friendlyname=%s,source=%s status=%s\n",
                $host,
                $realif,
                $ipaddr,
                $mac,
                $friendly,
                $source,
                $ifstatus
                );
}
?>
