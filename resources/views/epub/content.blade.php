<?php echo "<?xml version='1.0' encoding='utf-8'?>".PHP_EOL; ?>
<package xmlns="http://www.idpf.org/2007/opf" unique-identifier="uuid_id" version="2.0">
  <metadata xmlns:calibre="http://calibre.kovidgoyal.net/2009/metadata" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/terms/" xmlns:opf="http://www.idpf.org/2007/opf" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <dc:contributor opf:role="bkp">photoalbum-creator ({{ config('app.version') }}) [{{ config('app.url') }}]</dc:contributor>
    <meta name="calibre:timestamp" content="{{ \Carbon\Carbon::now()->toAtomString() }}"/>
    <dc:creator opf:file-as="Unknown" opf:role="aut">{{ $album->author }}</dc:creator>
    <dc:identifier id="uuid_id" opf:scheme="uuid">{{ $album->uuid }}</dc:identifier>
    <meta name="cover" content="cover"/>
    <meta name="book-type" content="comic"/>
    <meta name="zero-gutter" content="true"/>
    <meta name="zero-margin" content="true"/>
    <meta name="fixed-layout" content="true"/>
    <dc:publisher>{{ $album->publisher }}</dc:publisher>
    <dc:language>ja</dc:language>
    <dc:title>{{ $album->title }}</dc:title>
    <meta content="none" name="orientation-lock"/>
    <meta content="horizontal-rl" name="primary-writing-mode"/>
    <meta content="1600x2560" name="original-resolution"/>
    <meta content="false" name="region-mag"/>
  </metadata>
  <manifest>
    <item href="images/cover.jpg" id="cover" media-type="image/jpeg"/>
    <item href="text/cover.xhtml" id="cover_page" media-type="application/xhtml+xml"/>
    @foreach($album->pages()->orderBy('page', 'asc')->cursor() as $page)
      <item href="text/part{{ sprintf('%05d', $page->page) }}.xhtml" id="html{{ $page->page }}" media-type="application/xhtml+xml"/>
    @endforeach
    @foreach($album->pages()->orderBy('page', 'asc')->cursor() as $page)
        <item href="images/{{ sprintf('%05d', $page->page) }}.jpg" id="img{{ $page->page }}" media-type="image/jpeg"/>
    @endforeach
    <item href="styles/page_styles.css" id="page_css" media-type="text/css"/>
    <item href="styles/stylesheet.css" id="css" media-type="text/css"/>
    <item href="toc.ncx" id="ncx" media-type="application/x-dtbncx+xml"/>
  </manifest>
  <spine toc="ncx">
    <itemref idref="cover_page"/>
    @foreach($album->pages()->orderBy('page', 'asc')->cursor() as $page)
        <itemref idref="html{{ $page->page }}"/>
    @endforeach
</spine>
  <guide>
    <reference href="text/cover.xhtml" title="Cover" type="cover"/>
  </guide>
</package>
