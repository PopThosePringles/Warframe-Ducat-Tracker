## Warframe Ducat Tracker

Shows the ducat price of all items in relics.

Prices are pulled from the [Warframe Wiki](https://warframe.fandom.com/wiki/Ducats).

To update prices (i.e when a new prime is released), run this line.

```
net\pixeldepth\warframe\Warframe_Data :: fetch_data(true);
```

[Preview](misc/preview.png)

Uses [Twig](https://twig.symfony.com/) for templating.