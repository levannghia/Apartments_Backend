import React, { useState, useEffect } from 'react'
import Authenticated from '@/Layouts/Authenticated';
import { Head, Link } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';
import Pagination from '@/Components/Pagination';

export default function Index(props) {
    const [properties, setProperties] = useState(props.properties);
    const [search, setSearch] = useState(props.filters.search || '');
    const [perPage, setPerPage] = useState(props.filters.perPage || 5);

    // console.log(properties);

    const handleSearch = () => {
        Inertia.get(
            route('apartment.index'),
            { search: search, perPage: perPage },
            {
                // preserveState: true,
                preserveScroll: true,
                replace: true,
            }
        )
    }

    const changePerPage = (e) => {
        const newPerPage = e.target.value
        setPerPage(newPerPage);
        Inertia.get(
            route('apartment.index'),
            { search: search, perPage: newPerPage },
            {
                // preserveState: true,
                preserveScroll: true,
                replace: true,
            }
        );
    }

    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Apartment</h2>}
        >
            <Head title="Apartment" />
            <div className="py-8">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="flex flex-col">
                            <div className='flex flex-row justify-between pt-4 px-4'>
                                <div className='flex'>
                                    <select onChange={(e) => changePerPage(e)} defaultValue={perPage} className='mr-2'>
                                        <option value="5">5</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <Link href={route('apartment.create')} className="
                                                inline-flex
                                                items-center
                                                justify-center
                                                px-4
                                                border border-transparent
                                                text-base
                                                leading-6
                                                font-medium
                                                rounded-md
                                                text-white
                                                bg-green-600
                                                hover:bg-green-500
                                                focus:outline-none
                                                focus:border-indigo-700
                                                focus:shadow-outline-indigo
                                                active:bg-green-700
                                                transition
                                                duration-150
                                                ease-in-out
                                                disabled:opacity-50"
                                    >
                                        <span>Create</span>
                                    </Link>
                                </div>
                                <div className="max-w-xl">
                                    <div className="relative flex w-full flex-wrap items-stretch">
                                        <input
                                            type="text"
                                            className="relative m-0 -mr-0.5 block min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-indigo focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                                            placeholder="Search"
                                            onChange={(e) => setSearch(e.target.value)}
                                            value={search}
                                        />
                                        <button
                                            onClick={() => handleSearch()}
                                            className="relative z-[2] flex items-center rounded-r bg-indigo-500 px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-indigo-700 hover:shadow-lg focus:bg-indigo-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-indigo-800 active:shadow-lg"
                                            type="button"
                                            id="button-addon1"
                                            data-te-ripple-init
                                            data-te-ripple-color="light">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                                className="h-5 w-5">
                                                <path
                                                    fillRule="evenodd"
                                                    d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                                    clipRule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div className="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div className="inline-block min-w-full py-2">
                                    <div className="overflow-hidden">
                                        <table className="min-w-full text-center text-sm font-light">
                                            <thead
                                                className="border-b bg-neutral-50 font-medium dark:border-neutral-500 dark:text-neutral-800">
                                                <tr>
                                                    <th scope="col" className=" px-6 py-4">#</th>
                                                    <th scope="col" className=" px-6 py-4">Name</th>
                                                    <th scope="col" className=" px-6 py-4">Phone</th>
                                                    <th scope="col" className=" px-6 py-4">Website</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {properties?.data.map((property, index) => (
                                                    <tr className="border-b dark:border-neutral-500" key={index}>
                                                        <td className="whitespace-nowrap px-6 py-4 font-medium">{index + 1}</td>
                                                        <td className="whitespace-nowrap px-6 py-4">{property.name}</td>
                                                        <td className="whitespace-nowrap px-6 py-4">{property.phone_number}</td>
                                                        <td className="whitespace-nowrap px-6 py-4">{property.website}</td>
                                                    </tr>
                                                ))}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {properties.links.length > 3 &&
                            (<div className='m-2 p-2'>
                                <Pagination links={properties.links} nextPageUrl={properties.next_page_url} prevPageUrl={properties.prev_page_url}/>
                            </div>)}
                        </div>
                    </div>
                </div>
            </div>
        </Authenticated>
    )
}
