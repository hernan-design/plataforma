// resources/assets/js/components/decorators/selectors.js
import { recordProps } from '@orange-marmalade/paginate-this/dist/pageInfoTranslator';

export default function select(paginator) {

    const tabulateByState = () => ({
        results: paginator.get('results').toJS(),
        ids: paginator.get('results').map(r => r.get(recordProps().identifier)),
        isLoading: paginator.get('isLoading'),
        stale: paginator.get('stale')
    });

    const tabulateList = () => ({
        results: paginator.get('results').toJS(),
        ids: paginator.get('results').map(r => r.get(recordProps().identifier)),
        isLoading: paginator.get('isLoading'),
        isAdding: paginator.get('isAdding')
    })

    const filterData = () => ({
        isLoading: paginator.get('isLoading'),
        stale: paginator.get('stale'),
        filters: paginator.get('filters').toJS(),
        sort: paginator.get('sort'),
        sortReverse: paginator.get('sortReverse')
    });

    const lazyDrive = () => ({
        isLoading: paginator.get('isLoading'),
        isAdding: paginator.get('isAdding')
    });

    return {
        tabulateByState,
        tabulateList,
        filterData,
        lazyDrive
    }
}
