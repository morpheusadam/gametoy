<div align="center">

# 🎮 GameToy — WooCommerce Game Recharge API Bridge

### A WordPress + WooCommerce plugin that connects your store to an external game-recharge merchant REST API — syncing products and auto-submitting top-up orders, with logging and SMTP email notifications.

<p>
  <img src="https://img.shields.io/github/license/morpheusadam/gametoy?style=for-the-badge&color=4c1" alt="License" />
  <img src="https://img.shields.io/github/stars/morpheusadam/gametoy?style=for-the-badge&color=ffca28" alt="Stars" />
  <img src="https://img.shields.io/github/forks/morpheusadam/gametoy?style=for-the-badge&color=42a5f5" alt="Forks" />
  <img src="https://img.shields.io/github/last-commit/morpheusadam/gametoy?style=for-the-badge&color=8e44ad" alt="Last commit" />
  <img src="https://img.shields.io/github/repo-size/morpheusadam/gametoy?style=for-the-badge&color=e67e22" alt="Repo size" />
</p>

<p>
  <img src="https://img.shields.io/badge/WordPress-Plugin-21759B?style=for-the-badge&logo=wordpress&logoColor=white" alt="WordPress" />
  <img src="https://img.shields.io/badge/PHP-7%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
  <img src="https://img.shields.io/badge/WooCommerce-Integration-96588A?style=for-the-badge&logo=woocommerce&logoColor=white" alt="WooCommerce" />
  <img src="https://img.shields.io/badge/REST%20API-Client-009688?style=for-the-badge&logo=fastapi&logoColor=white" alt="REST API" />
  <img src="https://img.shields.io/badge/SMTP-Email-EA4335?style=for-the-badge&logo=maildotru&logoColor=white" alt="SMTP" />
</p>

</div>

---

## 📖 Overview

**GameToy** is a **WordPress plugin** that integrates your **WooCommerce** store with an external **game-recharge merchant REST API**. It bridges two systems: it pulls the merchant's goods catalog into WooCommerce as products, and — when a customer's order is completed — it automatically submits a corresponding top-up/recharge order back to the merchant API, then notifies the customer by email.

The plugin handles the full lifecycle: **authenticated API requests** (client ID, signed requests with timestamp + nonce), **product synchronization** into WooCommerce, **order submission** on `woocommerce_order_status_completed`, **activity logging** (account and debug logs), and **transactional email** via a bundled SMTP/mailer with an admin settings page. An admin dashboard page lets you configure credentials and inspect API responses, while account and log pages give visibility into syncs and submitted orders.

It is built for **store owners and developers** running a WooCommerce-based digital game top-up / recharge shop who need a reliable connector to a merchant fulfillment API.

> 🔎 **Keywords:** WooCommerce game recharge, WordPress merchant API integration, game top-up plugin, WooCommerce REST API client, product sync plugin, order submission automation, SMTP email WordPress, digital recharge store, game credit plugin.

---

## ✨ Features

- 🔗 **Merchant REST API integration** — authenticated requests (ClientId + signed `AuthSign` with timestamp and nonce) to the external recharge merchant API.
- 🛒 **Product sync into WooCommerce** — fetches the merchant goods list and creates/updates WooCommerce products (matched by SKU).
- ⚙️ **Automatic order submission** — on completed WooCommerce orders, submits the matching recharge order to the merchant API.
- 🆔 **Order helpers** — generates unique merchant order IDs, player IDs, and random values for each submission.
- 📧 **SMTP email notifications** — bundled mailer and email templates to notify customers, configurable from settings.
- 🧾 **Logging** — account and debug logs (`logs/account.log`, `logs/debug.log`) for syncs, submissions, and errors.
- 🖥️ **Admin dashboard** — settings page for credentials, plus pages to display API responses, product cards, and account/order logs.
- 🧩 **WooCommerce hooks** — clean integration via WooCommerce order-status actions.

---

## 🛠️ Tech Stack

| Layer | Technology |
| --- | --- |
| Platform | WordPress (plugin) |
| Commerce | WooCommerce |
| Language | PHP 7+ |
| Networking | cURL REST client (signed requests) |
| Email | SMTP / custom mailer |
| Front-end | JavaScript, CSS |

<p align="center">
  <img src="https://skillicons.dev/icons?i=wordpress,php,js" alt="Tech stack" />
</p>

---

## 🚀 Getting Started

### Prerequisites

- **WordPress 5.0+**
- **PHP 7.0+**
- **WooCommerce** installed and active
- Valid **merchant API credentials** (client ID / secret)

### Installation

1. Download the plugin (clone or grab a ZIP of this repository).
2. In your WordPress admin, go to **Plugins → Add New → Upload Plugin**.
3. Upload the archive and click **Install Now**.
4. **Activate** the plugin from the Plugins menu.

```bash
git clone https://github.com/morpheusadam/gametoy.git
```

---

## ⚙️ Configuration & Usage

1. Open the **GameToy** settings page in the WordPress admin and enter your merchant API credentials and SMTP details.
2. Trigger a **goods-list sync** to import merchant products into WooCommerce (matched and upserted by SKU).
3. Sell as usual — when an order reaches the **Completed** status, GameToy automatically submits the recharge order to the merchant API and emails the customer.
4. Review the **API response**, **account**, and **log** pages in the admin to monitor syncs and submissions.

---

## 🗂️ Project Structure

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
├── assets/                          # css · js
└── logs/                            # account.log · debug.log
```

---

## 🤝 Contributing

Contributions are welcome! Open an [issue](https://github.com/morpheusadam/gametoy/issues) or submit a pull request with new integrations, improvements, or fixes.

> ⚠️ **Security note:** do not commit real API credentials or secrets. Keep merchant keys in configuration/environment, not in source.

## 📜 License

Distributed under the **MIT License** (or see [`LICENSE`](LICENSE) if present).

---

<div align="center">

### 👤 Author — Morpheus Adam

Web developer & cheerful hacker · PHP · Laravel · Go

<p>
  <a href="https://github.com/morpheusadam"><img src="https://img.shields.io/badge/GitHub-morpheusadam-181717?style=for-the-badge&logo=github&logoColor=white" alt="GitHub" /></a>
  <a href="https://sam.zeonic.me"><img src="https://img.shields.io/badge/Website-sam.zeonic.me-4c1?style=for-the-badge&logo=googlechrome&logoColor=white" alt="Website" /></a>
  <a href="mailto:morpheusadam95@gmail.com"><img src="https://img.shields.io/badge/Email-Contact-D14836?style=for-the-badge&logo=gmail&logoColor=white" alt="Email" /></a>
</p>

⭐ **If GameToy powered your store, consider giving it a star!** ⭐

</div>


---

## ⭐ Star History

<a href="https://star-history.com/#morpheusadam/gametoy&Date">
  <img src="https://api.star-history.com/svg?repos=morpheusadam/gametoy&type=Date" alt="gametoy — Star History Chart" width="70%" />
</a>

<div align="center">

### If this project helps you, please give it a ⭐

A star helps other developers discover **gametoy** and supports continued development.

</div>
