# GMT Pricing Parity
Localize base prices for different countries. Automatically adjusts the price of items in-cart and displays a message.

Display a message about the localized pricing with the short code `[pricing_parity]`. Pass in a string with the variables below to customize.



## Template variables

- `{{country}}` - the country name
- `{{iso}}` - the country ISO code
- `{{amount}}` - the discount amount



## Working with the API

You can also get data back using the WP Rest API.

**Live Data**

```
<your-domain>/wp-json/gmt-pricing-parity/v1/discount/
```

**Test GeoIP**

```
<your-domain>/wp-json/gmt-pricing-parity/v1/discount/test/
```


## License

The code is available under the [GPLv3 License](LICENSE.md). This product includes GeoLite2 data created by MaxMind, available from
[https://www.maxmind.com](https://www.maxmind.com).