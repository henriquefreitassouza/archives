SELECT date_part('year', visit_date::date) AS year, date_part('month', visit_date::date) AS month, review, COUNT(review) AS reviews
FROM tenant_reviews_clean
GROUP BY year, month, review
/*HAVING review IN ('5', '4', '3', '2', '1')*/
/*HAVING review = '1'*/
/*HAVING review NOT IN ('5', '4', '3', '2', '1')*/
/*HAVING review = 'Visita não aconteceu.'*/
HAVING review = 'VaiNegociar'
ORDER BY year ASC, month ASC, review DESC;

SELECT *
FROM tenant_reviews_clean
WHERE visit_date LIKE '2018-08%'
ORDER BY visit_date;

SELECT date_part('year', visit_date::date) AS year, date_part('month', visit_date::date) AS month, COUNT(*) AS visits
FROM tenant_reviews_clean
/*WHERE review IN ('5', '4', '3', '2', '1')*/
GROUP BY year, month
ORDER BY year, month;

SELECT date_part('year', visit_date::date) AS year, date_part('month', visit_date::date) AS month,
(SUM(building::int)::decimal / COUNT(building)) AS building_compliant,
(SUM(conservation::int)::decimal / COUNT(conservation)) AS conservation_compliant,
(SUM(size::int)::decimal / COUNT(size)) AS size_compliant,
(SUM(price::int)::decimal / COUNT(price)) AS price_compliant,
(SUM(location::int)::decimal / COUNT(location)) AS location_compliant,
(SUM(did_not_like_the_location::int)::decimal / COUNT(did_not_like_the_location)) AS location_taste_not_compliant,
(SUM(expected_a_better_preserved_property::int)::decimal / COUNT(expected_a_better_preserved_property)) AS expectation_not_compliant,
(SUM(bigger_in_photos::int)::decimal / COUNT(bigger_in_photos)) AS photo_not_compliant,
(SUM(different_from_the_listing::int)::decimal / COUNT(different_from_the_listing)) AS difference_not_compliant
FROM tenant_reviews_clean
WHERE review IN ('5', '4', '3', '2', '1')
GROUP BY year, month
ORDER BY year, month;

SELECT * FROM tenant_reviews_clean LIMIT 10;

SELECT month, visits, tenant_that_visited, (tenant_that_visited::decimal / visits) AS visit_conversion_rate, offers, tenants_that_made_offers, (tenants_that_made_offers::decimal / offers) AS offer_conversion_rate, contracts, (contracts::decimal / tenants_that_made_offers) AS contract_conversion_rate
FROM visits_offers_contracts;

SELECT visit_date, neighbourhood, review, others FROM tenant_reviews_clean
WHERE others IS NOT NULL
AND review IN ('5', '4', '3', '2', '1');

SELECT date_part('year', visit_date::date) AS year, date_part('month', visit_date::date) AS month, review, COUNT(others) AS verbatim
FROM tenant_reviews_clean
WHERE others IS NOT NULL
AND review IN ('5', '4', '3', '2', '1')
GROUP BY year, month, review
ORDER BY year, month, review DESC;

SELECT visit_date, review, others
FROM tenant_reviews_clean
WHERE others IS NOT NULL
AND review = '1';
