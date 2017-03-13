# Nişanyan Blog Parser
nisanyan1.blogspot.com adresindeki tüm blog postları çekip kaydeden bir script yazdım. Aslında `base_uri` değişkenini değiştirerek diğer herhangi bir blogspot sitesini parse edecek şekilde değiştirilebilir. Ancak bunu denemedim

I have written a small script that parses and saves all the blog posts on nisanyan1.blogspot.com. Logically, this can be used to parse any other blogspot just by changing the `base_uri` varible in the code. This is just an idea, as I have not tried this.

### Nasıl Yüklenir
Bu oldukça standart bir PHP scripti. Sadece tek bir bağımlılığı var, o da Guzzle. İlk olarak repoyu kendi makinenize klonlayın:

`git clone https://github.com/raicem/nisanyan-blog-parser.git`

`cd` ile klasöre gidin  ve [Composer](https://getcomposer.org/) ile yükleyin:

`composer install`

Yükleme tamamlandıktan sonra, terminalden şu şekilde çalıştırabilirsiniz:
`php index.php`

Sonuç olarak tüm yazıları HTML formatında, `yazilar` klasörü altında görebilirsiniz. 
