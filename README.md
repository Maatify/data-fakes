![Maatify.dev](https://www.maatify.dev/assets/img/img/maatify_logo_white.svg)

---

[![Version](https://img.shields.io/packagist/v/maatify/data-fakes?label=Version&color=4C1)](https://packagist.org/packages/maatify/data-fakes)
[![PHP](https://img.shields.io/packagist/php-v/maatify/data-fakes?label=PHP&color=777BB3)](https://packagist.org/packages/maatify/data-fakes)
[![Build](https://github.com/Maatify/data-fakes/actions/workflows/test.yml/badge.svg?label=Build&color=brightgreen)](https://github.com/Maatify/data-fakes/actions/workflows/test.yml)

[![Monthly Downloads](https://img.shields.io/packagist/dm/maatify/data-fakes?label=Monthly%20Downloads&color=00A8E8)](https://packagist.org/packages/maatify/data-fakes)
[![Total Downloads](https://img.shields.io/packagist/dt/maatify/data-fakes?label=Total%20Downloads&color=2AA9E0)](https://packagist.org/packages/maatify/data-fakes)

[![Stars](https://img.shields.io/github/stars/Maatify/data-fakes?label=Stars&color=FFD43B&cacheSeconds=3600)](https://github.com/Maatify/data-fakes/stargazers)
[![License](https://img.shields.io/github/license/Maatify/data-fakes?label=License&color=blueviolet)](LICENSE)
[![Status](https://img.shields.io/badge/Status-Stable-success?style=flat-square)]()
[![Code Quality](https://img.shields.io/codefactor/grade/github/Maatify/data-fakes/main?color=brightgreen)](https://www.codefactor.io/repository/github/Maatify/data-fakes)

[![PHPStan](https://img.shields.io/badge/PHPStan-Level%206-4E8CAE)](https://phpstan.org/)
[![Coverage](https://img.shields.io/badge/Coverage-92%25-9C27B0)](#)

[![Changelog](https://img.shields.io/badge/Changelog-View-blue)](CHANGELOG.md)
[![Security](https://img.shields.io/badge/Security-Policy-important)](SECURITY.md)

---
# 📘 Maatify Data Fakes

**In-Memory Fake Adapters for MySQL, Redis, MongoDB & Repository Layer**  
**Version:** 1.0.2  
**Project:** `maatify/data-fakes`  
**Maintained by:** Maatify.dev

---

## 🚀 Overview

`maatify/data-fakes` is a deterministic, lightweight **in-memory data simulation engine** fully compatible with all official Maatify Data Adapters.

It allows any repository or service to run and be tested **without any real databases**, providing:

* Fake MySQL Adapter
* Fake MySQL DBAL Adapter
* Fake Redis Adapter
* Fake MongoDB Adapter
* Fake Repository Layer
* **Unit of Work + Snapshot Engine (Phase 6)**
* Fully deterministic test isolation
* Zero external services required — perfect for CI

All Fake Adapters follow the **exact same contracts** used by real adapters across the Maatify ecosystem.

---

## 🔑 Core Dependencies

The core of the library is built directly on two interfaces:

1. **AdapterInterface**  
   `Maatify\Common\Contracts\Adapter\AdapterInterface`

2. **ResolverInterface**  
   `Maatify\DataAdapters\Contracts\ResolverInterface`

Every Fake Adapter implements `AdapterInterface` and is routed through `ResolverInterface` to ensure **1:1 behavior** with real adapters.

---

## 🧩 Features

### 🗄️ Storage Features
* Fully in-memory storage layer
* Auto-increment & mixed ID handling
* Snapshot export/import (Phase 6)
* Deterministic state across tests

### 🔍 Query Features
* SQL-like filtering (where/in/like/order/limit)
* Mongo-like operators (`$in`, `$gt`, `$lte`, `$ne`, etc.)
* Redis-like operations (strings, lists, hashes, counters, TTL)

### 🧱 Repository Features
* FakeRepository
* FakeCollection
* ArrayHydrator

### 🔄 Unit of Work (Phase 6)
* Transaction begin/commit/rollback
* Nested transactions via stacked snapshots
* Atomic callback wrapper: `transactional()`

### 🔌 Adapter Lifecycle
* `connect()` / `disconnect()`
* `healthCheck()`
* `isConnected()`
* `getDriver()`

---

## 📦 Installation

```bash
composer require maatify/data-fakes --dev
```

✔ Intended for **testing environments**  
✘ Not intended for production usage

---

## 🧪 Basic Usage

### Using Fake Resolver

```php
use Maatify\DataFakes\Resolvers\FakeResolver;

$resolver = new FakeResolver();
$db = $resolver->resolve('mysql:main', true);

$rows = $db->select('users', ['id' => 1]);
```

### Reset Between Tests

```php
FakeStorageLayer::reset();
```

---

## 📁 Fake Components Included

### 🗄️ Fake Adapters
* FakeMySQLAdapter
* FakeMySQLDbalAdapter
* FakeRedisAdapter
* FakeMongoAdapter

### 🧩 Repository Layer (Phase 5)
* FakeRepository
* FakeCollection
* ArrayHydrator

### 🔀 Routing
* FakeResolver

### 🔄 Unit of Work & Snapshots (Phase 6)
* FakeUnitOfWork
* SnapshotManager
* SnapshotState

---

## 📝 Documentation

Full project documentation available in:

👉 **[`README.full.md`](README.full.md)**

Includes:

* Architecture design
* Phase-by-phase breakdown (Phase 1 → Phase 6)
* API Map
* Tests summary
* Internal notes

---

## 🪪 License

**[MIT license](LICENSE)** © [Maatify.dev](https://www.maatify.dev)  
Free to use, modify, and distribute with attribution.

---

## 👤 Author

**© 2025 Maatify.dev**  
Engineered by **Mohamed Abdulalim ([@megyptm](https://github.com/megyptm))**  
https://www.maatify.dev

📘 Full documentation & source code:  
https://github.com/Maatify/data-fakes

---

## 🤝 Contributors

Special thanks to the Maatify.dev engineering team and open-source contributors.

---

<p align="center">
  <sub><span style="color:#777">Built with ❤️ by <a href="https://www.maatify.dev">Maatify.dev</a> — Unified Ecosystem for Modern PHP Libraries</span></sub>
</p>


