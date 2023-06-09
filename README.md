
# URL Shortener SPA (Laravel + vue)

This is a simple URL shortener single page application built using Laravel and VueJS.


## Demo

Given a valid url
the server will generate a string (mix of numbers and alphabets) then store it in the database along with the original link 


#### Hashing function :
```
private function generateShortCode()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codeLength = 6;
        $shortCode = '';

        for ($i = 0; $i < $codeLength; $i++) {
            $shortCode .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $shortCode;
    }
```
#### 
#
By concatenating the newly generated short code with the App Base URL we the server will then redirect us to the original link associated with the requested short link
#### Redirect function :
#### api.php :
```
Route::get('/{shortCode}', [UrlShortenerController::class, 'redirect'])->name('redirect');
```
#### UrlShortenerController.php :
```
 public function redirect($shortCode)
    {
        $shortenedUrl = ShortenedUrl::where('short_code', $shortCode)->firstOrFail();

        $shortenedUrl->increment('click_count');

        return redirect($shortenedUrl->original_url);
    }
```





## Installation

### Laravel :
After cloning the project install laravel's requirement using composer

```bash
  composer install
```
Then copy .env.example to .env and configure your database
```bash
cp .env.example .env
```
Generate the application key :
```bash
php artisan generate:key
```
Create the tables using : 
```bash
php artisan:migrate
```
### Vue :
In the root of the project run :
```bash
npm install
```


    
## Run Locally

After the installation you can run the project locally by following these commands :

```bash
  php artisan serve
```
Then in another terminal

```bash
  npm run dev
```

