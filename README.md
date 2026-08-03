# Top Up Bridge

Top Up Bridge (plugin name `GameToy`) is a WordPress plugin that connects a WooCommerce store to an external game-recharge merchant REST API, for store owners and developers running a digital game top-up shop.

## Overview

The plugin bridges two systems. It pulls the merchant's goods catalog into WooCommerce as products, and when a customer's order reaches the Completed status it submits a matching recharge order back to the merchant API and emails the customer.

It covers the full lifecycle: authenticated API requests (client ID plus a signed `AuthSign` built from a timestamp and nonce), product synchronization into WooCommerce matched by SKU, order submission hooked to `woocommerce_order_status_completed`, account and debug logging, and transactional email through a bundled SMTP mailer. An admin dashboard page holds the credential settings and shows raw API responses; separate account and log pages give visibility into syncs and submitted orders.

## Features

- Merchant REST API integration with authenticated, signed requests.
- Product sync that creates or updates WooCommerce products, matched by SKU.
- Automatic recharge-order submission on completed WooCommerce orders.
- Generation of unique merchant order IDs, player IDs, and random values per submission.
- SMTP email notifications with templates, configurable from the settings page.
- Account and debug logs at `logs/account.log` and `logs/debug.log`.
- Admin pages for settings, API responses, product cards, and account/order logs.

## Requirements

- WordPress 5.0 or later
- PHP 7.0 or later
- WooCommerce installed and active
- Merchant API credentials (client ID and secret)

## Installation

1. Download the plugin, either by cloning the repository or downloading a ZIP.
2. In the WordPress admin, go to Plugins, then Add New, then Upload Plugin.
3. Upload the archive and click Install Now.
4. Activate the plugin from the Plugins menu.

```bash
git clone https://github.com/morpheusadam/TopUpBridge.git
```

## Configuration and usage

1. Open the GameToy settings page in the WordPress admin and enter the merchant API credentials and SMTP details.
2. Trigger a goods-list sync to import merchant products into WooCommerce. Products are upserted by SKU.
3. Sell as usual. When an order reaches the Completed status the plugin submits the recharge order to the merchant API and emails the customer.
4. Use the API response, account, and log pages in the admin to monitor syncs and submissions.

Do not commit real API credentials or secrets. Keep merchant keys in configuration or environment, not in source.

## Tech stack

| Layer | Technology |
| --- | --- |
| Platform | WordPress (plugin) |
| Commerce | WooCommerce |
| Language | PHP 7+ |
| Networking | cURL REST client with signed requests |
| Email | SMTP / custom mailer |
| Front-end | JavaScript, CSS |

## Project structure

```text
gametoy/
├── gametoy.php                       # main plugin bootstrap (includes)
├── admin/
│   └── gametoy-admin-page.php        # admin dashboard page
├── includes/
│   ├── class-gametoy-api.php         # merchant API client + product import
│   ├── class-gametoy-sync.php        # product synchronization
│   ├── class-gametoy-submitorder.php # submit recharge order to merchant API
│   ├── woocommerce-hooks.php         # order-status integration
│   ├── class_smtp.php                # SMTP mailer
│   ├── settings-page.php             # plugin settings
│   ├── log.php · logs-page.php       # logging + log viewer
│   ├── account-logs-page.php         # account activity logs
│   └── enqueue-scripts.php           # assets
├── assets/                           # css · js
└── logs/                             # account.log · debug.log
```

## Contributing

Open an [issue](https://github.com/morpheusadam/TopUpBridge/issues) or submit a pull request with new integrations, improvements, or fixes.

## License

MIT. See [`LICENSE`](LICENSE) if present.

## Author

Morpheus Adam — [GitHub](https://github.com/morpheusadam) · [sam.zeonic.me](https://sam.zeonic.me) · morpheusadam95@gmail.com
