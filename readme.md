## Instrukcja instalacji środowiska deweloperskiego

- Zainstaluj poniższe programy:
	- [VirtualBox](https://www.virtualbox.org/wiki/Downloads)
	- [Vagrant](http://www.vagrantup.com/downloads.html)
	- PHP
- Zaimportuj `Homestead Vagrant Box` używając poniższej komendy:
		
		vagrant box add laravel/homestead	
		
- Zainstaluj narzędzie CLI `composer` używając poniższej komendy:

		curl -sS https://getcomposer.org/installer | php
		sudo mv composer.phar /usr/local/bin/composer
		
- Zainstaluj narzędzie CLI `homestead` używając poniższej komendy:

		composer global require "laravel/homestead=~2.0"

- Zainicjuj tworzenie `Homestead Vagrant Box` używając komendy `homestead init`
		
- Jeśli nie posiadasz wygenerowanego klucza SSH to wygeneruj go teraz za pomocą komendy `ssh-keygen`

- Otwórz plik konfiguracyjny używając komendy `homestead edit` i zmień:
	
	- W dyrektywie `folders.map` wpisz ścieżkę do katalogu z projektami który znajduje się na twoim komputerze. `folders.to` możesz zostawić wartość domyślną
	
			folders:
    		   - map: ~/PHPProjects
			     to: /home/vagrant/Code
			     
	- W dyrektywie `sites` dopisz poniższy kod, zamiast `<<NAZWA FOLDERU>>` podaj nazwę folderu znajdującego się w folderze podanym wyżej w którym znajdują się pliki strony pobrane z repozytorium GIT'a:
	
    		- map: ekursy.local
      		  to: /home/vagrant/Code/<<NAZWA FOLDERU>>/public
      		  
- W pliku `/etc/hosts` dopisz poniższą linię:

		192.168.10.10  ekursy.local
		
- Uruchom środowisko używając komendy `homestead up`

- Sprawdź czy działa domena `ekursy.local`
