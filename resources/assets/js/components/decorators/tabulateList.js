// resources/assets/js/components/decorators/tabulateList.js
import { decorators } from '@orange-marmalade/paginate-this';
import select from './selectors';
import controlListState from './controlListState';

export default function tabulateList(WrapperList) {
    return decorators.decorate( controlListState(WrapperList), props => select(props.paginator).tabulateList() )
}
