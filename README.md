# ISC2 Boulder Chapter CTF Attack Lab

## This project is a portable, self-contained Capture The Flag lab that runs entirely on a local WiFi network.\
The network can be brought to an event and stood up to run the CTF competition autonomously once initialized. No internet is required during the event. New features and scenarios can be added in a modular way, as long as the contributor complies with the IP scheme and provide their flags in the `flags.ctf` format.

## Infrastructure

| IP | Device Type | Description |
| --- | --- | --- |
| 192.168.1.1 | Router | Provides WiFi network and DHCP services |
| 192.168.1.2 | Infra Raspberry Pi | Provides DNS and web containers for CTF instructions and flag turn-in |
| 192.168.1.3 | Target Raspberry Pi | Provides all target containers |
| 192.168.1.8 | Target PHPMyAdmin | Easy web-administration for target SQL server database *(stop during event)* |
| 192.168.1.9 | Infra PHPMyAdmin | Easy web-administration of CTF database *(stop during event)* |
| 192.168.1.10 | BIND9 Container | DNS services for CTF network |
| 192.168.1.12 | Infra PHP Container | PHP service for CTF web frontend |
| 192.168.1.20 | Infra NginX Container | CTF web frontend |
| 192.168.1.25 | Target NginX Container | Web services to be targeted in CTF |
| 192.168.1.26 | Target PHP container | PHP services for vulnerable website |
| 192.168.1.33 | Target SSH container | SSH services with final flags |
| 192.168.1.100-250 | DHCP Range | IP Addresses used by players |

### Raspberry Pi Build

#### 1. Flash MicroSD with **Raspberry Pi OS Lite 64bit** image.

#### 2. Initialize Pi

- Change Keyboard Layout to `Other` and `English US`
- Set username and password
- Set system hostname *Change screen resolution with* `sudo dpkg-reconfigure console-setup` *and selecting* `UTF-8` *then* `Guess optimal` *then* `Terminus` *and* `16x32`

> `sudo vi /etc/hosts`
*Change hostname list in the row for local host (last row) (i.e.* `127.0.0.1 ctf-infra`*)*

> `sudo nmtui`
- Set system network settings
> `set system hostname`
*Use same hostname that was used in `/etc/hosts`*

> `sudo shutdown -r now`

#### 3. Configure cgroups

> `sudo vi /boot/firmware/cmdline.txt`

*Append to the end of the only row in the file the following text* `cgroup_enable=cpuset cgroup_enable=memory cgroup_memory=1`

> `:wq!` *to save and exit vi*

#### 4. Setup Docker

> `sudo apt update && sudo apt upgrade -y`
>
> `sudo curl -fsSL https://get.docker.com | sh`
>
> `sudo usermod -aG docker $USER`
>
> `sudo shutdown -r now`

*Copy contents of this repository into /etc/docker*

> `sh set_permission.sh`

*Change directories into the desired role, i.e.* `cd infra` *if you want to build the needed core network services*

> `sh initialize_docker.sh`

***From this point forward, no internet connection is required***

#### 5. Resetting Database

*Change directories into the role the Raspberry Pi is performing*

> `docker compose down -v`
>
> `docker compose up`

### Upkeep

Periodically, software updates for the OS and new images should be downloaded in order to mitigate any unintended vulnerabilities of the system. To do so, run the following commands:

> `sudo apt update && sudo apt upgrade -y`

*Change into the directory of the role you are updating*

> `docker compose pull`

### Customization

#### Environment Variables

The MySQL Database utilizes the `.env` file to store variables. These variables include the root password, database name, and the username/password used by the php server. Using the `.env` file is a best practice and typically included in the `.gitignore` file. However, the file in its entirety is included so that no custom configuration is needed for this CTF network to work. In addition, the username/password are used in the `./<role>/www/db_connect.php` file. Any modifications to `.env` must equivalently be made in that file.

#### Flags

Flags are added to the database using the `./infra/mysql/csv/flags.csv` file. After the CSV file is modified, 2 steps must be taken for congruency within the CTF environment:

1. Update the respective file(s) where the flag is revealed to the user
2. Run the "Resetting Database" step listed above for the infra role

## Solutions

Upon connection to the network, the player will know the following:

- The Subnet (and therefore the broadcast address)
- The DNS server IP address

### Reconnaissance

#### Ping Sweep for IP discovery

##### Linux / MacOS

> `for i in {1..50}; do ping -c1 -W1 192.168.1.$i &>/dev/null && echo "192.168.1.$i is up"; done`

##### Windows (PowerShell)

> `1..50 | ForEach-Object { if (Test-Connection -Count 1 -Quiet 192.168.1.$_) { "192.168.1.$_ is up" } }`

#### ARP results for faster but less accurate IP discovery

##### Linux

> `sudo ping -b 192.168.1.255`
>
> `arp -a`

##### Windows / MacOS

> `ping 192.168.1.255`
>
> `arp -a`

#### Port Sweep for service identification

##### Linux / MacOS

> `nc -zv 192.168.1.x 20-1024 2>&1 | grep succeeded`

##### Windows (PowerShell)

> `1..1024 | Where-Object { (New-Object Net.Sockets.TcpClient).ConnectAsync("192.168.1.x", $_).Wait(100) } | ForEach-Object { "Port $_ is open" }`

#### DNS Discovery

##### Linux / MacOS

> `dig @192.168.1.10 -x 192.168.1.10`
>
> `dig @192.168.1.10 any isc2boulder.ctf`

##### Windows / Linux / MacOS

> `nslookup`
>
> `server 192.168.1.10`
>
> `set type=any`
>
> `192.168.1.10`
>
> `isc2boulder.ctf`

#### Windows (PowerShell)

> `Resolve-DnSName -Server 192.168.1.10 -Name 192.168.1.10 -Type ANY`
>
> `Resolve-DnSName -Server 192.168.1.10 -Name isc2boulder.ctf -Type ANY`

### Exploit Exposed Services

#### Manipulate Page Content

*Open Developer's Tools to modify HTML source code*

1) Change POST to GET to reveal passed values
2) Change hidden value and see how the page reponds

#### Injection and XSS

*Manipulate provided fields to find susceptibility to Cross Site Scripting and SQL Injection*

### Pivot

*Use discovered credentials to log into other servers*

### Cryptography

*Use local tools to decode the final flag*

## Contact Information

This project was created by the ISC2 Boulder Chapter for educational purposes.

### Michael Reeves

- 🌐 <https://isc2boulderchapter.org/>
- ✉ mike@isc2boulderchapter.org