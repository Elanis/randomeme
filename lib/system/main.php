<?php
/* countCore
INPUT : -
OUTPUT : Number of Cores ( int )
*/

function countCore()
{
        if (!($num_cores = shell_exec('/bin/grep -c ^processor /proc/cpuinfo')))
        {
            if (!($num_cores = trim(shell_exec('/usr/bin/nproc'))))
            {
                $num_cores = 1;
            }
        }

        if ((int)$num_cores <= 0)
            $num_cores = 1;

        return (int)$num_cores;
}

/* CpuStats
INPUT: -
OUTPUT: Informations ( table ) */

function CpuStats()
{
	$cpu = array();
	
	//Nombre de Coeurs
	$cpu['count'] = countCore();
	
	//Default Values
	$cpu['model'] = 'N/A';
	$cpu['temp'] = 'N/A';
	$cpu['freq'] = 'N/A';
	
	if ($cpuinfo = shell_exec('cat /proc/cpuinfo'))
	{
		$processors = preg_split('/\s?\n\s?\n/', trim($cpuinfo));

		foreach ($processors as $processor)
		{
			$details = preg_split('/\n/', $processor, -1, PREG_SPLIT_NO_EMPTY);

			foreach ($details as $detail)
			{
				list($key, $value) = preg_split('/\s*:\s*/', trim($detail));

				switch (strtolower($key))
				{
					case 'model name':
					case 'cpu model':
					case 'cpu':
					case 'processor':
						$cpu['model'] = $value;
					break;

					case 'cpu mhz':
					case 'clock':
						$cpu['freq'] = $value.' MHz';
					break;
				}
			}
		}
	}
	
	if ($cpu['freq'] == 'N/A')
	{
		if ($f = shell_exec('cat /sys/devices/system/cpu/cpu0/cpufreq/cpuinfo_max_freq'))
		{
			$f = $f / 1000;
			$cpu['freq'] = $f.' MHz';
		}
	}
	
	// CPU Temp
    if (exec('/usr/bin/sensors | grep -E "^(CPU Temp|Core 0)" | cut -d \'+\' -f2 | cut -d \'.\' -f1', $t))
    {
        if (isset($t[0]))
            $cpu['temp'] = $t[0].' °C';
    }
    else
    {
        if (exec('cat /sys/class/thermal/thermal_zone0/temp', $t))
        {
            $cpu['temp'] = round($t[0] / 1000,1).' °C';
        }
    }


    $cpu['util'] = sys_getloadavg();
	return $cpu;
}

/* SystemStats
INPUT: -
OUTPUT: Informations ( table ) */

function SystemStats()
{
	$system = array();
	$system['hostname'] = php_uname('n');
	
	if (!($system['os'] = shell_exec('/usr/bin/lsb_release -ds | cut -d= -f2 | tr -d \'"\'')))
	{
		if(!($system['os'] = shell_exec('cat /etc/system-release | cut -d= -f2 | tr -d \'"\''))) 
		{
			if (!($system['os'] = shell_exec('find /etc/*-release -type f -exec cat {} \; | grep PRETTY_NAME | tail -n 1 | cut -d= -f2 | tr -d \'"\'')))
			{
				$system['os'] = 'N.A';
			}
		}
	}
	$system['os'] = trim($system['os'], '"');
	$system['os'] = str_replace("\n", '', $system['os']);
	
	if (!($upt_tmp = shell_exec('cat /proc/uptime')))
	{
		$system['last_boot'] = 'N.A';
	}
	else
	{
		$upt = explode(' ', $upt_tmp);
		$system['last_boot'] = date('d-m-Y H:i:s', time() - intval($upt[0]));
	}

	if (!($system['current_users'] = shell_exec('who -u | awk \'{ print $1 }\' | wc -l')))
	{
		$system['current_users'] = 'N.A';
	}
	
	return $system;
}

/* MemoryStats
INPUT: -
OUTPUT: Informations ( table ) */

function MemoryStats()
{
	$memory = array();
<<<<<<< HEAD
	if (!($memory['total'] = shell_exec('grep MemTotal /proc/meminfo | awk \'{print $2}\'')))
=======
	if (!($memory['total'] = (int)shell_exec('grep MemTotal /proc/meminfo | awk \'{print $2}\'')))
>>>>>>> 7f7a52037a5c50ca4971a906e4abf64218d95294
	{
		$memory['total'] = 0;
	}
	
	$memory['free'] = 0;

	if (shell_exec('cat /proc/meminfo'))
	{
		$free    = shell_exec('grep MemFree /proc/meminfo | awk \'{print $2}\'');
		$buffers = shell_exec('grep Buffers /proc/meminfo | awk \'{print $2}\'');
		$cached  = shell_exec('grep Cached /proc/meminfo | awk \'{print $2}\'');

		$memory['free'] = (int)$free + (int)$buffers + (int)$cached;
	}

	$memory['used'] = $memory['total'] - $memory['free'];
	
	$memory['percent_free'] = round($memory['free']/$memory['total'] *100,1);
	$memory['percent_used'] = 100 - $memory['percent_free'];
	
	return $memory;
	
}

/* SwapStats
INPUT: -
OUTPUT: Informations ( table ) */

function SwapStats()
{
	$swap = array();
<<<<<<< HEAD
	if (!($swap['total'] = shell_exec('grep SwapTotal /proc/meminfo | awk \'{print $2}\'')))
=======
	if (!($swap['total'] = (int) shell_exec('grep SwapTotal /proc/meminfo | awk \'{print $2}\'')))
>>>>>>> 7f7a52037a5c50ca4971a906e4abf64218d95294
	{
		$swap['total'] = 0;
	}
	
	$swap['free'] = 0;

<<<<<<< HEAD
	if (!($swap['free'] = shell_exec('grep SwapFree /proc/meminfo | awk \'{print $2}\'')))
=======
	if (!($swap['free'] = (int) shell_exec('grep SwapFree /proc/meminfo | awk \'{print $2}\'')))
>>>>>>> 7f7a52037a5c50ca4971a906e4abf64218d95294
	{
	    $swap['free'] = 0;
	}

	$swap['used'] = $swap['total'] - $swap['free'];
	
	$swap['percent_free'] = round($swap['free']/$swap['total'] *100,1);
	$swap['percent_used'] = 100 - $swap['percent_free'];
	
	return $swap;
	
}

/* DiskUsage
INPUT: -
OUPUT: Informations ( table ) 
*/
function DiskUsage()
{
	$disk = array();
	$disk['free'] = disk_free_space ("/");
	$disk['total'] = disk_total_space ("/");
	$disk['used'] = $disk['total'] - $disk['free'];
	$disk['percent_used'] = round($disk['used'] / $disk['total']  * 100,1);
	return $disk;
}