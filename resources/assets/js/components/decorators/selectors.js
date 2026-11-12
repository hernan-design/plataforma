// resources/assets/js/components/decorators/selectors.js
import { recordProps } from '@orange-marmalade/paginate-this/dist/pageInfoTranslator';

export default function select(paginator) {
    const rawResults = paginator && typeof paginator.get === 'function' ? paginator.get('results') : null;
    const getResults = () => (rawResults && typeof rawResults.toJS === 'function' ? rawResults.toJS() : (rawResults || []));
    const getIds = () => (rawResults && typeof rawResults.map === 'function'
        ? rawResults.map(r => (r && typeof r.get === 'function' ? r.get(recordProps().identifier) : r[recordProps().identifier]))
        : []);
    const getProp = (key, fallback = false) => (paginator && typeof paginator.get === 'function' ? paginator.get(key) : fallback);

    const tabulateByState = () => ({
        results: getResults(),
        ids: getIds(),
        isLoading: getProp('isLoading'),
        stale: getProp('stale')
    });

    const tabulateList = () => ({
        results: getResults(),
        ids: getIds(),
        isLoading: getProp('isLoading'),
        isAdding: getProp('isAdding')
    });

    const filterData = () => {
        const rawFilters = getProp('filters', null);
        return {
            isLoading: getProp('isLoading'),
            stale: getProp('stale'),
            filters: rawFilters && typeof rawFilters.toJS === 'function' ? rawFilters.toJS() : (rawFilters || {}),
            sort: getProp('sort', null),
            sortReverse: getProp('sortReverse')
        };
    };

    const lazyDrive = () => ({
        isLoading: getProp('isLoading'),
        isAdding: getProp('isAdding')
    });

    return {
        tabulateByState,
        tabulateList,
        filterData,
        lazyDrive
    }
}
