<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:dct="http://purl.org/dc/terms/" xmlns:foaf="http://xmlns.com/foaf/0.1/" xmlns:rdfs="http://www.w3.org/2000/01/rdf-schema#" xmlns:dctype="http://purl.org/dc/dcmitype/" xmlns:dcat="http://vocab.deri.ie/dcat#">
    <dcat:CatalogRecord rdf:about="">
        <foaf:homepage rdf:resource="http://www.datos.gov.cl/datasets/rdf/5"/>
        <dct:publisher>
            <foaf:Organization>
                <dct:title xml:lang="es">datos.gob.cl</dct:title>
                <foaf:homepage rdf:resource="<?= current_url() ?>"/>
            </foaf:Organization>
        </dct:publisher>

        <dct:spatial>
            <rdf:Description>
                <rdfs:label xml:lang="es">Chile</rdfs:label>
                <rdfs:seeAlso rdf:resource="http://sws.geonames.org/3895114/"/>
            </rdf:Description>
        </dct:spatial>
        <dct:title xml:lang="es">Catálogo de datos abiertos de Chile</dct:title>
        <dct:license rdf:resource="http://creativecommons.org/licenses/by/2.0/cl/"/>

        <dcat:dataset rdf:resource="#dataset_<?=$dataset->getId()?>"/>
    </dcat:CatalogRecord>

    <dcat:Dataset rdf:about="#dataset_<?=$dataset->getId()?>">
        <dct:modified><?=$dataset->getUpdatedAt()->format('Y-m-d H:i:s')?></dct:modified>
        <dct:title xml:lang="es"><?=$dataset->getTitulo()?></dct:title>
        <dct:description xml:lang="es"><?=$dataset->getDescripcion()?></dct:description>
        <dct:publisher>

            <foaf:Organization>
                <dct:title><?=$dataset->getServicio()->getNombre()?></dct:title>
                <?php if($dataset->getServicio()->getUrl()):?>
                <foaf:homepage rdf:resource="<?=$dataset->getServicio()->getUrl()?>"/>
                <?php endif; ?>
            </foaf:Organization>
        </dct:publisher>
        <dct:issued><?=$dataset->getPublicadoAt()->format('Y-m-d H:i:s')?></dct:issued>
        <dct:identifier><?=$dataset->getId()?></dct:identifier>

        <?php foreach($dataset->getSectores() as $s):?>
        <dct:spatial>
            <rdf:Description rdf:about="<?=$s->getUrl()?>">
                <rdfs:label><?=$s->getNombre()?></rdfs:label>
            </rdf:Description>
        </dct:spatial>
        <?php endforeach; ?>

        <dct:license><?=$dataset->getLicencia()->getUrl()?></dct:license>
        <?php ($dataset->getGranularidad()) ? '<dcat:granularity>'.$dataset->getGranularidad().'</dcat:granularity>' : '' ?>

        <?php foreach($dataset->getTags() as $t):?>
        <dcat:keyword xml:lang="es"><?=$t->getNombre()?></dcat:keyword>
        <?php endforeach;?>

        <?php foreach($dataset->getRecursos() as $r):?>
        <dcat:distribution>
            <dcat:Distribution>
                <rdf:type rdf:resource="http://vocab.deri.ie/dcat#Download"/>
                <dcat:accessURL><?= str_replace('&', '&amp;', $r->getUrl())?></dcat:accessURL>
                <dct:format>
                    <dct:IMT>
                        <rdf:value><?=$r->getMime()?></rdf:value>
                    </dct:IMT>
                </dct:format>
            </dcat:Distribution>
        </dcat:distribution>
        <?php endforeach;?>

    </dcat:Dataset>

</rdf:RDF>