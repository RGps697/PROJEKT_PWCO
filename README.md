# PROJEKT_PWCO

## Dokumentacja użytkownika

Adres URL: https://todolist-env.eba-2msrzw2i.us-east-1.elasticbeanstalk.com/

Aplikacja "To Do List" pozwalająca na dodawanie, usuwanie i edytowanie zadań przetrzymywanych w bazie danych. 
- Dodawanie nowych zadań odbywa się poprzez wypełnienie pierwszego pola tekstowego i wybraniu przycisku "Dodaj".
- Edytowanie zadań odbywa się przez wpisanie w drugie pole tekstowe ID zadania oraz nowej wartości w pierwsze pole tekstowe, a następnie wybraniu przycisku "Edytuj".
- Usuwanie zadań odbywa się przez wpisanie w drugie pole tekstowe ID zadania i wybraniu przycisku "Usuń".

## Dokumentacja techniczna

### Pliki aplikacji:
- index.php - strona główna aplikacji, posiadająca formularz operacji CRUD oraz tabelę wyświetlającą rekordy zadań przechowywanych w bazie danych.
- connection.php - skrypt odpowiadający za połączenie z bazą danych oraz zalogowaniu na użytkownika
- taskOperation.php - skrypt przechowujący funkcje z zapytaniami SQL do bazy danych

### Najważniejsze etapy konfiguracji:

#### Utworzenie EC2 key pair
1. W panelu nawigacyjnym konsoli EC2 znalezienie opcję "Key Pairs" w kategorii "Network & Security".
2. Wybranie opcji "Create key pair".
3. Uzupełnienie formularza tworzenia tak jak na obrazku:
![image](https://user-images.githubusercontent.com/72736232/205346632-d98216dc-9aca-4644-9770-baeadc66022a.png)
4. Zatwierdzenie ustawień przez "Create key pair" na dole formularza.
5. Zapisanie klucza prywatnego na dysku C:/ oraz wyłączenie dziedziczenia i usunięcie wszystkich uprawnień użytkowników innych niż właściciel dla tego pliku.

#### Utworzenie środowiska Elastic Beanstalk
1. W konsoli Elastic Beanstalk wybranie przycisku "Create new environment".
2. Zaznaczenie opcji "Web server environment".
3. Wypełnienie pola "Application name".
4. Ustawienia platformy:
![image](https://user-images.githubusercontent.com/72736232/205345111-248bb86f-d482-4035-a4ba-9ff44fafe456.png)
5. Wybranie opcji "Configure more options".
6. W panelu "Security" wybrać opcję "Edit" oraz dodać wcześniej utworzony klucz "EC2 key pair" i zapisanie zmian.
7. Zatwierdzenie utworzenia środowiska przez "Create environment" na dole formularza.

### Utworzenie CI/CD CodePipeline
1. W konsoli CodePipeline wybranie opcji "Create pipeline".
2. Uzupełnienie formularza: ![image](https://user-images.githubusercontent.com/72736232/205349400-28d5c76b-742a-4a1d-8574-f933c7efada5.png)
3. Utworzenie połączenia (2. Add source stage) do repozytorium znajdującego się w GitHub (wymagane zalogowanie) ![image](https://user-images.githubusercontent.com/72736232/205349746-3d04740c-46a9-4bd2-a056-332ef274d76b.png)
4. Pominięcie kroku "3. Add build stage".
5. Skonfigurowanie aplikacji, do której wysyłane będą zmiany przy zatwierdzeniu w repozytorium (4. Add deploy stage)![image](https://user-images.githubusercontent.com/72736232/205350708-39e05945-a689-41ae-a962-684bddd477b0.png)
6. Zatwierdzenie konfiguracji w kroku przeglądu.

#### Konfiguracja Security Groups
1. W konsoli EC2 w panelu nawigacji wybranie opcji "Instances" w kategorii "Instances".
2. Odnalezienie instancji o naziwe "Todolist-env" będącej maszyną dla aplikacji w Elastic Beanstalk.
3. Zaznaczenie checkboxa obok instancji oraz przejście do kategorii "Security" w nowo otwartym panelu na stronie.
4. Naciśnięcie linku znajdującego się pod "Security groups":![image](https://user-images.githubusercontent.com/72736232/205351717-64b5a51c-ce23-494c-9ee9-168b6c9415be.png)
5. Wybranie "Edit inbound rules" w kategorii "Inbound rules" oraz skonfigurowanie następująco reguł:![image]![image](https://user-images.githubusercontent.com/72736232/205352887-04679934-5048-47e5-b5f2-fb9a25a65723.png)
6. Przejście do panelu "Security groups" i skonfigurowanie "Inbound rules" rekordu, który odpowiadał za połączenia HTTP i HTTPS z poprzedniego kroku, według ilustracji: ![image](https://user-images.githubusercontent.com/72736232/205353056-b0a7c6a8-bc58-4637-b295-c1f085a14f89.png)

#### Utworzenie bazy danych AWS RDS
1. W konsoli RDS wybranie "Databases" z panelu nawigacji.
2. Wybranie przycisku "Create new database".
3. W konfiguracji wybranie "Standard create".
4. "Engine options":![image](https://user-images.githubusercontent.com/72736232/205360152-39e780bf-e3c6-4e4d-8a57-af966e78883c.png)
5. W kategorii "Template" wybranie "Free tier".
6. W kategorii "Settings" nadanie nazwy identyfikacyjnej "todolistapp" oraz wypełnienie pól nazwy użytkownika oraz haseł:![image](https://user-images.githubusercontent.com/72736232/205360605-86455ad2-b460-4137-98c6-572d1246b9a1.png)
7. W kategorii "Storage" wybranie minimalnej wartości dla pojemności oraz wyłączenie autoskalowalności
8. W kategorii "Conectivity" wybranie "Connect to EC2 compute resource" oraz wybranie maszyny aplikacji w menu poniżej. Dodanie do Security Group, w której skonfigurowane było połączenie SSH z adresu IP swojego komputera.
9. Utworzenie bazy danych przez przycisk "Create database".
10. Połączenie programem HeidiSQL do instancji:![image](https://user-images.githubusercontent.com/72736232/205362626-c91cd696-7d29-4dc8-9c16-a72109384358.png)
11. Utworzenie nowej bazy danych i tabeli:![image](https://user-images.githubusercontent.com/72736232/205362761-8120cb1f-8c8a-4740-a9f2-c6e11455e76e.png)
12. Zapisanie zmian i zakończenie połączenia.

#### Połączenie SSH do instancji EC2 oraz wygenerowanie klucza prywatnego z certyfikatem:
Połączenie do instancji przez wiersz poleceń: ssh -i C:\ec2appkey.pem ec2-user@34.227.152.255
Instalacja OpenSSL: sudo apt-get install openssl
Wygenerowanie klucza i certyfikatu (Najistotniejszym polem jest Common Name, w którym powinien znaleźć się publiczny adres IP instancji EC2): 
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/nginx.key -out /etc/ssl/certs/nginx.crt

![image](https://user-images.githubusercontent.com/72736232/205354710-7783cc70-9f09-4517-bc68-f188f8b1fba5.png)
**Zawartość plików skopiować (potrzebne do konfiguracji HTTPS w następnym kroku)**

W panelu "Load Balancers" wybranie rekordu, który posiada nasłuchiwacze do aplikacji, a następnie dodanie nowego nasłuchiwacza. Przy konfiguracji wybrać HTTPS oraz port 443, wraz z dodaniem certyfikatu do ACM z kluczem oraz certyfikatem wygenerowanym przy połączeniu SSH do instancji EC2:
![image](https://user-images.githubusercontent.com/72736232/205357991-0b3ac72e-fcd9-44e3-973b-2c65c4b87a54.png)




