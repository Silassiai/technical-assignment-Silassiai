import React, {useState} from 'react';
import {default as DT} from 'react-data-table-component';

function DataTable({columns = [], data = [], ...props}) {

    const [loading,] = useState(false);
    const totalRows = data.length

    return <>
        <DT
            {...props}
            columns={columns}
            data={data}
            progressPending={loading}
     		paginationTotalRows={totalRows}
        />

    </>
}

export default DataTable;
