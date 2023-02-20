import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, router} from '@inertiajs/react';
import DataTable from '@/Components/DataTable';
import {useEffect, useState} from 'react';
import axios from 'axios';
import PrimaryButton from "@/Components/PrimaryButton";

const ExpandedComponent = ({data}) => {
    const {reply_message, id, body, seen_at} = data || {};
    const [replyMessageValue, setReplyMessageValue] = useState(reply_message || 'Bedankt voor je order.');
    const [hasBeenReplied, setHasBeenReplied] = useState(null !== reply_message);
    const [backendResponse, setBackendResponse] = useState(null);

    const markOrderAsOpened = () => {
        if (null === seen_at) {
            axios.put(`/order/${id}/read`).then((r) => {
                router.reload({only: ['orders']})
            }).catch((e) => {
                console.log({e})
            })
        }
    }

    const submitReply = () => {
        axios.put(`/order/${id}/reply`, {reply_message: replyMessageValue}).then((r) => {
            router.reload({only: ['orders']});
            setHasBeenReplied(true);
        }).catch((e) => {
            if (e?.response?.data?.message) setBackendResponse(e.response.data.message);
        })
    }

    useEffect(() => {
        markOrderAsOpened();
    }, [])

    return <>
        <div
            className={`flex flex-wrap gap-4 p-4 `}
        >

            <div className={`flex grow shrink-0 basis-full`}>{body || 'No message body'}</div>

            <div className={`flex grow shrink-0 basis-full`}>
                <textarea
                    disabled={hasBeenReplied}
                    className={`w-full p-2 border rounded-md ${hasBeenReplied ? 'bg-gray-100' : ''}`}
                    onChange={(e) => setReplyMessageValue(e.currentTarget.value)}
                    value={replyMessageValue} placeholder='Write a reply here'
                />
            </div>
            {backendResponse && <div className={`text-red-600`}>{backendResponse}</div>}
            {
                !hasBeenReplied ? (
                    <PrimaryButton onClick={submitReply}>
                        Reply
                    </PrimaryButton>
                ) : null
            }
        </div>

    </>
}

export default function Index({auth, errors, orders}) {

    const dtColumns = [
        {
            name: 'id',
            selector: row => row.id,
        },
        {
            name: 'mail_d',
            selector: row => row.mail_id,
        },
        {
            name: 'subject',
            selector: row => row.subject,
        },
        {
            name: 'received_at',
            selector: row => row.received_at,
        },
        {
            name: 'received_from',
            selector: row => row.received_from,
        },
        {
            name: 'seen_at',
            selector: row => row.seen_at,
        },
    ];

    const conditionalRowStyles = [
        {
            when: row => null === row.seen_at,
            style: row => ({
                fontWeight: row.seen_at ? 'normal' : 'bold',
            }),
        },
    ];

    return (
        <AuthenticatedLayout
            auth={auth}
            errors={errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Orders</h2>}
        >
            <Head title="Order"/>

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <p>Below you see the orders that has been imported in the database from de dedicated email.</p>
                            <p>If you do not see any orders, you should run the below command:</p>
                            <p><code className={`bg-slate-200 px-2 py-1 rounded`}>php artisan sync:inbox-orders</code></p>
                            <p>Or running the scheduler locally</p>
                            <p><code className={`bg-slate-200 px-2 py-1 rounded`}>php artisan schedule:work</code></p>
                        </div>
                    </div>
                </div>
            </div>
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    <DataTable
                        columns={dtColumns}
                        conditionalRowStyles={conditionalRowStyles}
                        data={orders.data}
                        expandableRows={true}
                        expandableRowsComponent={ExpandedComponent}
                    />

                </div>
            </div>
        </AuthenticatedLayout>
    );
}
