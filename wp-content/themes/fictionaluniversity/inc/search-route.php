<?php
add_action('rest_api_init', 'university_register_search');

function university_register_search()
{
    register_rest_route('university/v1', 'search', array(
        //WP_REST_SERVER::READABLE is alternate of GET
        'method' => WP_REST_SERVER::READABLE,
        'callback' => 'universitySearchResults'
    ));
}

// callback function for university_register_search
function universitySearchResults($data)
{

    $mainQuery = new WP_Query(array(
        'post_type' => array('post', 'page', 'program', 'professor', 'campus', 'event'),
        's' => sanitize_text_field($data['term'])
    ));

    $results = array(
        'generalInfo' => array(),
        'programs' => array(),
        'professors' => array(),
        'events' => array(),
        'campuses' => array(),
    );

    while ($mainQuery->have_posts()) {
        $mainQuery->the_post();

        if (get_post_type() == 'post' or get_post_type() == 'page') {
            array_push($results['generalInfo'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'postType' => get_post_type(),
                'authorName' => get_the_author()
            ));
        }

        if (get_post_type() == 'program') {
            //related campus to program search starts
            $relatedCampus = get_field('related_campus');
            if($relatedCampus) {
                foreach($relatedCampus as $campus) {
                    array_push($results['campuses'], array(
                        'title' => get_the_title($campus),
                        'permalink' => get_the_permalink($campus)
                    ));
                }
            }
            //related campus to program search ends
            
            array_push($results['programs'], array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        }

        if (get_post_type() == 'professor') {
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
            ));
        }

        if (get_post_type() == 'event') {
            $eventDate = new DateTime(get_field('event_date'));
            $description = "";

            if (has_excerpt()) {
                $description = get_the_excerpt();
            } else {
                $description = wp_trim_words(get_the_content(), 18);
            }
            array_push($results['events'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'description' => $description,
                'month' => $eventDate->format('M'),
                'day' => $eventDate->format('d')
            ));
        }

        if (get_post_type() == 'campus') {
            array_push($results['campuses'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        }
    }


    // Related Program Events, Professors
    if ($results['programs']) {
        $programsMetaQuery = array('relation' => 'OR');


        foreach ($results['programs'] as $item) {
            array_push(
                $programsMetaQuery,
                array(
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . $item['id'] . '"'
                )
            );
        }

        $relatedProgramQuery = new WP_Query(array(
            'post_type' => array('professor', 'event'),
            'meta_query' => $programsMetaQuery
        ));

        while ($relatedProgramQuery->have_posts()) {
            $relatedProgramQuery->the_post();
            if (get_post_type() == 'professor') {
                array_push($results['professors'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
                ));
            }

            if (get_post_type() == 'event') {
                $eventDate = new DateTime(get_field('event_date'));
                $description = "";
    
                if (has_excerpt()) {
                    $description = get_the_excerpt();
                } else {
                    $description = wp_trim_words(get_the_content(), 18);
                }
                array_push($results['events'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'description' => $description,
                    'month' => $eventDate->format('M'),
                    'day' => $eventDate->format('d')
                ));
            }
        }

        $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
        $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
    }


    return $results;
}
