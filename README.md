![oppaigallery](https://cloud.githubusercontent.com/assets/8536299/19834013/e1c40426-9e4e-11e6-9bc1-330371a97092.png)

OppaiGallery *v0.5*
=========
« OppaiGallery » is a offline (not designed for online usage) library manager for R18 Japanese pornography artworks.
It display latests media added, support search, tags, random feature and have also a mini admin panel.
Just put it on a NAS or a raspberry pi with local web server feature.

> **SQL Procedures**: 
> SQL DB include 4 procedures and need 5 tables, sql procedures can be called like this:
>
>```  CALL latest_medias(3); ```
>```  CALL medias_by_tag('your tag'); ```
>```  CALL random_medias(3); ```
>```  CALL tags_count(); ```

Can be reused to make a music library links db (soundcloud, mixcloud, etc..), youtube videos library, or whatever you think it can be re-used for...
