# Uno Object Store
A brutally simple quasi-functional object store. Don't @ me.

When you need a dead-simple API mock or an unprotected object store.

I needed one for my async-saving local notepad, 'cause my OS keeps running out of resources.
You might need it for a really fast mock of that app you're so deadline-pushed.

One day wind may bring middleware support. Until then, keep it away from public access!

To run, point your webserver of choice to serve all endpoints through public/index.php. Heck, if you're mocking an API, just run
`php -S address:port -t public`

You will need a database store, so go to `data` folder and run `sqlite3 store.db ".read schema.sql"`. That will create a store for you.

**Requirements?** PHP, SQLite PDO driver.

**Special parameters:**
- Use GET ?pathsOnly on listing paths to get keys only.
- Use GET ?full on item paths to get full entity with `path`. Entity's contents will be in `contents` field.
- Use PUT/PATCH/DELETE ?withStatus to get JSON messages with affected row count. Without this, the status is indicated in HTTP status code -- 20x for OK, 4xx for errors.
