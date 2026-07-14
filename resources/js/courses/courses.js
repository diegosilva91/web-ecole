import {GetObject} from "../axios-services";

async function getCourses(queryBase, query, page, typeCourse, thread)
{
    let data;

    if (page) {
        query += `&page=${page}`;
    }
    if (query) {
        queryBase = queryBase + query;
    }
    try {
        data = await GetObject(queryBase,null,thread);

        if ('courses' in data) {
            data.courses.data ? data.courses.data.map(value => {
                value.start_at = new Date(value.first_promotion.start_at.replace(/-/g, "/"));
                if (TypeCourse[typeCourse] === 'filter_trajectories') {
                    value.end_at = new Date(value.last_promotion.end_at.replace(/-/g, "/"));
                }
                if (!value.newLink) {
                    value.newLink = '';
                }
            }) : '';
            if ('items' in data.courses && 'count' in data.courses) {
                data.courses.items.map(courses => {
                    try {
                        courses.map(value => {
                            if ('type_course' in value) {
                                value.start_at = new Date(value.first_promotion.start_at.replace(/-/g, "/"));
                                if (value.type_course === 1) {
                                    value.end_at = new Date(value.last_promotion.end_at.replace(/-/g, "/"));
                                }
                            }
                        })
                    } catch (e) {
                        console.log(e);
                    }
                });
            }
        }
    } catch (e) {
        console.log(e)
        data = {courses: [], url: ''};
    }
    return data;
}

const TypeCourse = {
    2: 'filter_campus',
    1:'filter_trajectories',
    0:'filter_intensives'
};

const TypeBackCourse = {
    'filter_intensives': 0,
    'filter_trajectories': 1,
    'filter_campus': 2
};

export {getCourses,TypeCourse, TypeBackCourse};
