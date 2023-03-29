Po uruchomieniu aplikacji nalezy uruchomic seedery:
 ./vendor/bin/sail php artisan db:seed
 
 
 Zadanie 1 z Laravel:

 Spowoduje to dodanie klientow, uzytkownikow (pracownikow), zamowien i przedmiotow.

 Pod adresem url /zadanie1 wyswietli nam sie podstawowa lista Orders pokazująca zawarte w niej informacje o kliencie, pracowniku i 5 przedmimiotach w zamowieniu.


 Zadanie 2

 Pod adresem url /zadanie2 znajdziemy listę uytkownikow i 5 przypisanych do niego aut, z czego jedno jest zaznaczone jako uzywane przez niego.
 Przy łączeniu auta z uzytkownikiem uzyta jest nastepujaca logika:
 Dodane auta mogą byc uzywane i dodane do innego uzytkownika, ale te zaznaczane jako uzywane jest uzywane tylko przez jednego uzytkownika :)