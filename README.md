სერვერზე ატვირთვისას და ყველა განახლებაზე

ბრძანება: 

1) php artisan migrate
2) php artisan db:seed

--------------------------------------------------------------

უნდა შეიქმნას .env ფაილი .env.example ასლი
.env ში დასარედაქტირებელი პარამეტრები:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

APP_URL=საიტის მისამართი
APP_NAME=Rebox

მეილის მონაცემები
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"



