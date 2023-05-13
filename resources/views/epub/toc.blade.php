<?php echo "<?xml version='1.0' encoding='utf-8'?>".PHP_EOL; ?>
<ncx xmlns="http://www.daisy.org/z3986/2005/ncx/" version="2005-1" xml:lang="jpn">
  <head>
    <meta content="{{ $album->uuid }}" name="dtb:uid"/>
    <meta content="2" name="dtb:depth"/>
    <meta content="photoalbum-creator ({{ config('app.version') }})" name="dtb:generator"/>
    <meta content="0" name="dtb:totalPageCount"/>
    <meta content="0" name="dtb:maxPageNumber"/>
  </head>
  <docTitle>
    <text>{{ $album->title }}</text>
  </docTitle>
  <navMap>
    <navPoint class="chapter" id="num_0" playOrder="0">
      <navLabel>
          <text>Cover</text>
      </navLabel>
      <content src="text/cover.xhtml"/>
    </navPoint>
    @foreach($album->pages()->orderBy('page', 'asc')->cursor() as $page)
      <navPoint class="chapter" id="num_{{ $page->page }}" playOrder="{{ $page->page - 1 }}">
          <navLabel>
              <text>Page-{{ $page->page }}</text>
          </navLabel>
          <content src="text/part{{ sprintf('%05d', $page->page) }}.xhtml"/>
      </navPoint>
    @endforeach
  </navMap>
</ncx>
