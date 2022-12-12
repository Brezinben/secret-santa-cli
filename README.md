# secret-santa-cli
Un secret santa en CLI pour Antoine BLUCHET, afin de faire un test technique le 12/12/22. 
PS : C'est mon premier projet en Symfony, je suis preneur de toute amélioration possible 😎 

```bash
cp .env.example .env
```

Install:

```bash
composer install
```

Create sqlite database:

```bash
touch database.sqlite
```

Run migrations:

```bash
symfony console doctrine:migrations:migrate
```

Run the draw (**with -v for more fun**):

```bash
symfony console app:draw-secret-senta "Tonia,tonia.mccombs@consolidated-farm-research.net|Prasert,pras_mcla@progressenergyinc.info|Geneva,genev-welke@arketmay.com|Tivon,tivon.ru@progressenergyinc.info|Dodd,dod.deherrera@arketmay.com|Sandie,sa.bixby@careful-organics.org|Hali,hal.stri@arketmay.com|Dharuna,dha_re@progressenergyinc.info|Nita,nit.fuss@egl-inc.info|Miner,minesant@egl-inc.info|Emmanuel,em-wesle@arketmay.com|Bankim,ba.rive@arvinmeritor.info|Narmada,na.welke@consolidated-farm-research.net|Bela,belamess@egl-inc.info|Tran,tra-matt@egl-inc.info|Zea,zea.hei@arketmay.com|Corrine,corrin.vit@acusage.net|Santosh,sant_san@careful-organics.org|Ventura,ve-swindl@careful-organics.org|Vina,vinadurham@careful-organics.org" -v
```

All In One

```bash
cp .env.example .env && composer install  && touch database.sqlite && symfony console doctrine:migrations:migrate && symfony console app:draw-secret-senta "Tonia,tonia.mccombs@consolidated-farm-research.net|Prasert,pras_mcla@progressenergyinc.info|Geneva,genev-welke@arketmay.com|Tivon,tivon.ru@progressenergyinc.info|Dodd,dod.deherrera@arketmay.com|Sandie,sa.bixby@careful-organics.org|Hali,hal.stri@arketmay.com|Dharuna,dha_re@progressenergyinc.info|Nita,nit.fuss@egl-inc.info|Miner,minesant@egl-inc.info|Emmanuel,em-wesle@arketmay.com|Bankim,ba.rive@arvinmeritor.info|Narmada,na.welke@consolidated-farm-research.net|Bela,belamess@egl-inc.info|Tran,tra-matt@egl-inc.info|Zea,zea.hei@arketmay.com|Corrine,corrin.vit@acusage.net|Santosh,sant_san@careful-organics.org|Ventura,ve-swindl@careful-organics.org|Vina,vinadurham@careful-organics.org" -v
```

Utils links:
- https://symfony.com/doc/current/validation.html
- https://symfony.com/doc/current/console.html
- https://symfony.com/doc/current/doctrine.html
