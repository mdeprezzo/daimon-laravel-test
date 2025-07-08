import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, router } from '@inertiajs/react';
import { useEffect, useState } from 'react';

import PrimaryButton from '@/Components/PrimaryButton';

export default function Dashboard() {
    const [breweries, setBreweries] = useState([]);
    const [loading, setLoading] = useState(true);
    const [page, setPage] = useState(1)
    const [perPage, setPerPage] = useState(20)    

    const nextPage = async (e) => {
        setPage(page + 1)
    };    

    const prevPage = async (e) => {
        setPage(page - 1)
    };    

    useEffect(() => {
        let token = null
        if (token = Cookies.get('auth_token')) {
          window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
        } else {
            router.visit('login')
        }

        const params: any = { page, per_page: perPage }

        window.axios
            .get(route('api.breweries.index'), { params })
            .then(response => {
                setBreweries(response.data.data);
                setLoading(false);
            })
      }, [page, perPage]);    

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Lista Birrifici
                </h2>
            }
        >
            <Head title="Lista Birrifici" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg p-10">                
                        <ul>
                            {breweries.map((brewery) => (
                                <li key={brewery.id} className="p-3">
                                    <p>{brewery.name} – {brewery.city} ({brewery.country})</p>
                                    <p className="text-xs text-gray-400">{brewery.id}</p>
                                </li>
                            ))}
                        </ul>

                        <hr />
                        
                        <div className="flex justify-between mt-4">
                            <PrimaryButton className="ms-4" disabled={page == 1} onClick={prevPage}>
                                Indietro
                            </PrimaryButton>   

                            <PrimaryButton className="ms-4" onClick={nextPage}>
                                Avanti
                            </PrimaryButton>                  
                        </div>      
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
