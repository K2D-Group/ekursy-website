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

## Instrukcja instalacji aplikacji

- Sklonuj repozytorium GIT'a do docelowego folderu (np. `~/PHPProjects/ekursy.local`)

		git clone git@bitbucket.org:k2d-team/strona-www.git
		
- Połącz się ze środowiskiem testowym i przejdź do folderu aplikacji

		homestead ssh
		cd Code/ekursy.local

- Zainstaluj zależności projektu i nadaj uprawnienia uruchamiania dla pliku `artisan`

		composer install
		chmod +x artisan
		
- Uruchom konfigurator i odpowiedz na pytania konfiguracyjne

		./artisan config:env -d
		
- Wygeneruj nowy klucz bezpieczeństwa aplikacji

		./artisan key:generate
		
## Dyrektywy konfiguracyjne


- `APP_ENV` - Środowisko - do wyboru:
	- `local` - środowisko testowe
	- `production` - środowisko produkcyjne
	
- `APP_DEBUG` - Tryb debugowania - do wyboru:
	- `true` - wyświetlane są błędy i pasek debugowania
	- `false` - wyświetla tylko standardową informację o błędzie

- `APP_KEY` - Klucz bezpieczeństwa aplikacji
	
- `DB_DRIVER` - Sterownik bazy danych - do wyboru:
	- `sqlite` - SQLite 3
	- `mysql` - MySQL

- `DB_HOST` - Adres serwera MySQL

- `DB_DATABASE` - Nazwa bazy danych

- `DB_USERNAME` - Użytkownik

- `DB_PASSWORD` - Hasło

- `CACHE_DRIVER` - Sterownik pamięci podręcznej - do wyboru:
	- `file` - Pliki
	- `database` - Baza danych
	- `array` - nic, czyli jedna wielka FIKCJA

- `SESSION_DRIVER` - Sterownik pamięci podręcznej - do wyboru:
	- `file` - Pliki
	- `database` - Baza danych
	- `cookie` - Ciasteczka
	- `array` - nic, czyli jedna wielka FIKCJA

- `QUEUE_DRIVER` - Sterownik mechanizmu kolejek - do wyboru:
	- `sync` - Asynchroniczny - bez kolejkowania
	- `database` - Baza danych
	- `beanstalkd` - Serwer beanstalkd

- `BITBUCKET_KEY` - BitBucket oAuth Key (do pobrania ze strony ustawień na BB w zakładce oAuth)

- `BITBUCKET_SECRET` - BitBucket oAuth Secret (do pobrania ze strony ustawień na BB w zakładce oAuth)

- `BITBUCKET_TEAM` - Nazwa grupy na której znajdują się repozytoria kursów. (w naszyp przypadku `k2d-team`)

