let T = (lang) => {
  return fetch('/i18n/search.json')
    .then(response => response.json())
    .then(t => {
      return t[lang];
    });
};

let loadIndex = (lang, query) => {
  return fetch('/search-index.' + lang + '.json')
  .then(results => results.json())
  .then(idx => {
    return {
      results: lunr.Index.load(idx.index).search(query),
      corpus: idx.corpus
    }
  })
  .catch(error => { return null; });
};

let render = (container, blueprint, data, mode = 'create') => {
  return fetch('/js/templates/' + blueprint + '.html')
    .then(response => response.text())
    .then(source => {
      let template = Handlebars.compile(source);
      if (mode == 'update') container.insertAdjacentHTML('beforeend', template(data));
      else container.innerHTML = template(data);

      return container;
    });
};

let paginate = (pager, size, page) => {
  return pager.slice((page - 1) * size, size * page);
};

const lang = document.documentElement.getAttribute('lang');
const translate = T(lang);
let translated = {};

translate.then(i18n => {
  Object.keys(i18n).forEach(function(key, index) {
    translated[key] = i18n[key];
  });
});

window.addEventListener('load', () => {
  const url_params = new URLSearchParams(window.location.search);
  const page_title = document.getElementsByTagName('h1')[0];
  const search_title = document.getElementById('search-title');
  const serp_title = document.getElementById('search-text');
  const query = url_params.get('q');

  if (query == null || query.trim() == "") {
    page_title.innerText = translated.page_title,
    search_title.remove();
    serp_title.innerText = translated.serp_text
  } else {
    let base_url = window.location.origin + '/';

    if (lang != 'pt') base_url = base_url + lang + '/';

    loadIndex(lang, query).then(match_list => {
      page_title.innerText = translated.serp_title + ': ' + query;

      if (match_list) {
        const results = match_list.results.length;

        if (!results) serp_title.innerText = translated.serp_text_not_found;
        else {
          serp_title.remove();

          const serp = document.getElementById('search-results');
          const serp_box = document.createElement('div');

          search_title.innerHTML = (results == 1) ? results + ' ' + translated.search_title_single : results + ' ' + translated.search_title_plural;
          serp_box.setAttribute('class', 'flex flex-wrap');

          let matches = [];

          for (const match in match_list.results) {
            let publishdate = match_list.corpus[match_list.results[match].ref].publishdate;
            let summary = match_list.corpus[match_list.results[match].ref].summary;
            let categorylink = base_url + 'categories/' + match_list.corpus[match_list.results[match].ref].categories;
            let permalink = base_url + 'stories/' + match_list.corpus[match_list.results[match].ref].permalink;
            let thumbnail = permalink + 'images/thumbnail.jpg';

            matches.push({
              author: match_list.corpus[match_list.results[match].ref].author,
              publishdate: publishdate,
              formatteddate: publishdate.replace(/(\d+)\-(\d+)\-(\d+)T(\d+)\:(\d+)\:(\d+).*/, '$3/$2/$1 $4:$5:$6'),
              category: match_list.corpus[match_list.results[match].ref].categories,
              categorylink: categorylink,
              title: match_list.corpus[match_list.results[match].ref].title,
              thumbnail_exists: match_list.corpus[match_list.results[match].ref].thumbnail_exists,
              thumbnail: thumbnail,
              summary: (summary.length > 199) ? summary.substring(0, 200) + ' ...' : summary,
              permalink: permalink,
              read_more: translated.read_more
            });
          }

          let page = 1;
          let page_size = 6;
          let matches_page = paginate(matches, page_size, page);

          render(serp_box, 'post_thumbnail', {matches_page}, 'create').then(block => serp.append(block)).then(rendered => {
            if (matches.length > page_size) {
              let total_pages = matches.length / page_size;
              let pages = [1];

              for (let i = 1; i < total_pages; i++) pages.push(i + 1);

              let updated_serp = render(serp, 'pagination', {
                'current_page': page,
                'pages': pages
              }, 'update');

              updated_serp.then(block => {
                let page_buttons = block.getElementsByClassName('button-page');
                page_buttons[0].setAttribute('class', 'button-page bg-gray-900 hover:no-underline hover:text-white focus:ring-gray-900 dark:text-white dark:hover:text-white');
                page_buttons[0].parentElement.setAttribute('aria-current', 'page');

                for (let i = 0; i < page_buttons.length; i++) {
                  page_buttons[i].addEventListener('click', function(e) {
                    page = parseInt(this.innerHTML);
                    this.setAttribute('class', 'button-page bg-gray-900 hover:no-underline hover:text-white focus:ring-gray-900 dark:text-white dark:hover:text-white');
                    this.parentElement.setAttribute('aria-current', 'page');

                    for (let k = 0; k < page_buttons.length; k++) {
                      if (page_buttons[k].innerHTML == this.innerHTML) continue;

                      page_buttons[k].setAttribute('class', 'button-page bg-primary hover:no-underline hover:text-white hover:bg-primary-darker focus:ring-primary-darker dark:text-white dark:hover:text-white');
                      page_buttons[k].parentElement.removeAttribute('aria-current');
                    }

                    matches_page = paginate(matches, page_size, page);
                    render(serp_box, 'post_thumbnail', {matches_page}, 'create');
                  });
                }
              });
            }
          });
        }
      }
    });
  }
});
