/**
 * grunt exec:viacheslav_luma_en_us && grunt less:viacheslav_luma_en_us && grunt watch
 * grunt exec:viacheslav_luma_uk_ua && grunt less:viacheslav_luma_uk_ua && grunt watch
 */

module.exports = {
    viacheslav_luma_uk_ua: {
        area: 'frontend',
        name: 'Viacheslav/luma',
        locale: 'uk_UA',
        files: [
            'css/styles-m',
            'css/styles-l'
        ],
        dsl: 'less'
    },
    viacheslav_luma_en_us: {
        area: 'frontend',
        name: 'Viacheslav/luma',
        locale: 'en_US',
        files: [
            'css/styles-m',
            'css/styles-l'
        ],
        dsl: 'less'
    }
};
