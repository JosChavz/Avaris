# Avaris
BudgetTrak 2.0


## Debugging

In the case that `npm run build:css` or `npm run watch:css` throws an error like:

```
thread '<unnamed>' panicked at /usr/local/cargo/registry/src/index.crates.io-6f17d22bba15001f/rayon-core-1.12.1/src/registry.rs:168:10:
The global thread pool has not been initialized.: ThreadPoolBuildError { kind: IOError(Os { code: 11, kind: WouldBlock, message: "Resource temporarily unavailable" }) }
note: run with `RUST_BACKTRACE=1` environment variable to display a backtrace
fatal runtime error: failed to initiate panic, error 5
Aborted (core dumped)
```

Please run `export RAYON_NUM_THREADS=1` to your CLI, or add to your ~/.zshrc or ~/.bashrc file, then source it.
