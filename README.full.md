# 📘 Maatify Data Fakes

**In-Memory Fake Adapters for MySQL, Redis, MongoDB & Repository Layer**  
**Version:** 1.0.1  
**Project:** `maatify/data-fakes`  
**Maintained by:** Maatify.dev

---

## 🚀 Overview

`maatify/data-fakes` is a deterministic, lightweight **in-memory data simulation engine** fully compatible with all official Maatify Data Adapters.

It allows any repository or service to run and be tested **without real databases**, providing:

- Fake MySQL Adapter
- Fake MySQL DBAL Adapter
- Fake Redis Adapter
- Fake MongoDB Adapter
- Fake Repository Layer (Phase 5)
- Fully deterministic test isolation
- Zero external services required — perfect for CI

All Fake Adapters follow the **exact same contracts** used by real adapters across the Maatify ecosystem.

---

## 🔑 Core Dependencies

The library fundamentally relies on:

1. **AdapterInterface**  
   `Maatify\Common\Contracts\Adapter\AdapterInterface`

2. **ResolverInterface**  
   `Maatify\DataAdapters\Contracts\ResolverInterface`

This ensures **1:1 compatibility** between fake drivers and their real counterparts.

---

## 🧩 Features

- Full in-memory storage engine
- Auto-increment ID emulation
- SQL-like filtering, ordering, limit/offset
- Mongo-like operators (`$in`, `$gt`, `$lte`, `$ne`)
- Redis-like primitives (strings, lists, hashes, counters, TTL)
- Repository layer:
    - `FakeRepository`
    - `FakeCollection`
    - `ArrayHydrator`
- Clean Adapter lifecycle:
    - `connect()`, `disconnect()`
    - `healthCheck()`, `isConnected()`
    - `getDriver()`

---

## 📦 Installation

```bash
composer require maatify/data-fakes --dev
````

✔ For testing environments
✘ Not intended for production usage

---

## 🧪 Basic Usage

### Using FakeResolver

```php
use Maatify\DataFakes\Resolvers\FakeResolver;

$resolver = new FakeResolver();
$db = $resolver->resolve('mysql:main', true);

$rows = $db->select('users', ['id' => 1]);
```

### Reset storage between tests

```php
FakeStorageLayer::reset();
```

---

## 📁 Included Components

### Fake Adapters

* FakeMySQLAdapter
* FakeMySQLDbalAdapter
* FakeRedisAdapter
* FakeMongoAdapter

### Repository Layer

* FakeRepository
* FakeCollection
* ArrayHydrator

### Routing

* FakeResolver

---

## 📘 Full Documentation

Full implementation details are available in:
👉 **[`README.full.md`](README.full.md)**

Contents include:

* Architecture design
* Development phases (Phase 1 → Phase 5)
* API Map
* Class overviews
* Tests summary
* Internal behavior notes

---

## 🪪 License

**[MIT license](LICENSE)** © [Maatify.dev](https://www.maatify.dev)

---

## 👤 Author

Engineered by **Mohamed Abdulalim ([@megyptm](https://github.com/megyptm))**
[https://www.maatify.dev](https://www.maatify.dev)

📘 Full source:
[https://github.com/Maatify/data-fakes](https://github.com/Maatify/data-fakes)

---

<p align="center">
  <sub><span style="color:#777">Built with ❤️ by <a href="https://www.maatify.dev">Maatify.dev</a> — Unified Ecosystem for Modern PHP Libraries</span></sub>
</p>
