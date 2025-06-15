<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

**By Venia Sollery Aliyya Hasna**

## Fraud Scanner

A Laravel-based web application that detects fraudulent activity in customer data fetched from an external API.

## 🚨 What Counts as Fraudulent?

A customer is flagged as fraudulent if **any** of the following rules apply:

- They share the **same IP address** or **same IBAN** with another customer.
- Their **phone number** originates **outside the Netherlands**.
- They are **younger than 18 years old**.

---

## 🛠️ Tech Stack

- **Laravel** – Full-stack PHP framework.
- **MySQL** – Stores scanned data and fraud results.
- **Tailwind CSS** – Utility-first CSS framework for styling.
- **Database Caching** – Uses Laravel’s built-in database cache driver.

---

## ✅ Features

- Fetches and processes customer data from an API.
- Applies fraud detection rules and stores results.
- Displays scan results in a clean, paginated interface.


