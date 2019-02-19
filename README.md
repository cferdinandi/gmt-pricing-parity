# GMT Pricing Parity
Display country-specific EDD discounts to visitors.

Display with the short code `[pricing_parity]`. Pass in a string with the variables below to customize.



## Template variables

- `{{country}}` - the country name
- `{{iso}}` - the country ISO code
- `{{code}}` - the discount code
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