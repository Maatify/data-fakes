# 📘 Maatify Data Fakes

**In-Memory Fake Adapters for MySQL, Redis, MongoDB & Repository Layer**  
**Version:** 1.0.2  
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
- Fake Repository Layer
- **Fake Unit of Work & Snapshot Engine (Phase 6)**
- Fully deterministic test isolation
- No external services required — perfect for CI

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

### 🔌 Fake Adapter Capabilities
- Full in-memory storage engine
- Auto-increment ID emulation
- SQL-like filtering, ordering, limit/offset
- Mongo-like operators (`$in`, `$gt`, `$lte`, `$ne`)
- Redis-like primitives (strings, lists, hashes, counters, TTL)

### 🧱 Repository Layer
- `FakeRepository`
- `FakeCollection`
- `ArrayHydrator`

### 🔄 Unit of Work & Snapshots (Phase 6)
- Full transactional grouping
- Nested transactions
- Instant rollback
- Deterministic and isolated state
- Storage-level snapshots for all adapters

### ⚙ Adapter Lifecycle
- `connect()`, `disconnect()`
- `healthCheck()`, `isConnected()`
- `getDriver()`

---

## 📦 Installation

```bash
composer require maatify/data-fakes --dev
```

✔ Recommended for testing & CI  
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

### 🔹 Fake Adapters
- FakeMySQLAdapter
- FakeMySQLDbalAdapter
- FakeRedisAdapter
- FakeMongoAdapter

### 🔹 Repository Layer
- FakeRepository
- FakeCollection
- ArrayHydrator

### 🔹 Routing
- FakeResolver

### 🔹 **Unit of Work (Phase 6)**
- `FakeUnitOfWork`
- `SnapshotManager`
- `SnapshotState`

---

## 🧩 Architectural Highlights

### FakeStorageLayer
- Central deterministic memory engine
- Shared across all fake adapters
- Supports snapshot export/import
- Auto ID management

### Snapshot System (Phase 6)
- Immutable snapshot objects
- Storage-wide state capture
- Full restore support

### Unit of Work (Phase 6)
- Stacked snapshots
- Nested begin/commit/rollback
- Transactional helper wrapper
- Adapter-agnostic

---

## 📚 Development Phases

- **Phase 1:** Project Bootstrap & Core Architecture
- **Phase 2:** Fake MySQL + DBAL Adapter
- **Phase 3:** Fake Redis Adapter
- **Phase 4:** Fake Mongo Adapter
- **Phase 5:** Repository Layer
- **Phase 6:** **Unit of Work + Snapshot Engine** 🆕

---

## 📘 Full Documentation

Full implementation details:

- Architecture overview
- Development phases (1 → 6)
- API map
- Class reference
- Test behavior and isolation rules
- Adapter lifecycles
- Repository usage

---

## 🪪 License

**[MIT license](LICENSE)** © [Maatify.dev](https://www.maatify.dev)

---

## 👤 Author

Engineered by **Mohamed Abdulalim ([@megyptm](https://github.com/megyptm))**  
https://www.maatify.dev

📘 Full source:  
https://github.com/Maatify/data-fakes

---

<p align="center">
  <sub><span style="color:#777">Built with ❤️ by <a href="https://www.maatify.dev">Maatify.dev</a> — Unified Ecosystem for Modern PHP Libraries</span></sub>
</p>
