
# Take-Home

I am intrested in showing yo my test project .


## Installation

1. Install my-project with composer

```
composer install
```

2.Copy the ```.env.example``` file and rename to ```.env``` and comoplete your database information fields.



3. Fill the news provider information in the ```.env```



## Deployment

To deploy this project run

```bash
php artisan key:generate
php artisan serve
```


## Documentation

#Add new provider

Create an provider locate at  ```/app/Provider/News``` it is better that its name be ```{PROVIDER_NAME}_NewsProvide.php``` also shoud extend from ```NewsProvider``` and impliment ```NewsProviderInterface```


#API


1-Fill the provider api-key(s)
2-The route for get latest news is:
```
/news
```

3-This route works via some query that is a kind of filter or custom search, these keys are:
```
id
title
category
source
writer
publishedAt
```
Also sort via these params:
```
publishedAt
publishedAtDesc
```

And pagination params like:
```
perPage
page
```

Ex:
```
http://127.0.0.1:8000/news?sort=publishedAtDesc&title=years
http://127.0.0.1:8000/news?sort=publishedAtDesc&page=2&perPage=20
http://127.0.0.1:8000/news?id=1

```