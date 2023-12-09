import React, { useRef, useState } from "react";
import Authenticated from "@/Layouts/Authenticated";
import { Head, useForm } from "@inertiajs/inertia-react";
import axios from "axios";
import { Editor } from '@tinymce/tinymce-react';

export default function Create(props) {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        website: '',
        phone: '',
        about: '',
        zip: '',
        city: '',
        state: '',
        street: '',
    })
    const editorRef = useRef(null);
    const [state, setState] = useState([]);
    const [street, setStreet] = useState([]);
    const handleChangeCity = async (e) => {
        setData('city', e.target.value)
        const { data } = await axios.get(route('country.state'), {
            params: {
                id: `${e.target.value}`,
            }
        });
        if (data.data) {
            setState(data.data);
            setStreet([]);
        }
        else {
            setState([]);
        }
    }

    const handleChangeState = async (e) => {
        setData('state', e.target.value)
        const { data } = await axios.get(route('country.street'), {
            params: {
                id: `${e.target.value}`,
            }
        });
        if (data.data) setStreet(data.data);
        else setStreet([]);
    }

    function submit(e) {
        e.preventDefault()
        post(route('apartment.store'), {
            preserveScroll: true,
        });
    }

    return (
        <Authenticated
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Create Apartment</h2>}
        >
            <Head title="Create Apartment" />
            <div className="py-8">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                            <div className="text-sm font-medium text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                                <ul className="flex flex-wrap -mb-px">
                                    <li className="me-2">
                                        <a
                                            href="#"
                                            className="inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500"
                                            aria-current="page"
                                        >
                                            Information
                                        </a>
                                    </li>
                                    <li className="me-2">
                                        <a
                                            href="#"
                                            className="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                        >
                                            Apartments
                                        </a>
                                    </li>

                                    <li className="me-2">
                                        <a
                                            href="#"
                                            className="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                        >
                                            Pets
                                        </a>
                                    </li>
                                    <li className="me-2">
                                        <a
                                            href="#"
                                            className="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                        >
                                            Features
                                        </a>
                                    </li>
                                    <li>
                                        <a
                                            className="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                        >
                                            Scores
                                        </a>
                                    </li>
                                    <li>
                                        <a
                                            className="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                        >
                                            Reviews
                                        </a>
                                    </li>
                                </ul>
                                <div className="pt-4">
                                    <form className="mx-auto" onSubmit={submit}>
                                        <div className="flex md:flex-row flex-col md:space-x-6">
                                            <div className="md:basis-3/5">
                                                <div className="mb-5">
                                                    <label
                                                        htmlFor="name"
                                                        className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                                    >
                                                        Name
                                                    </label>
                                                    <input
                                                        value={data.name}
                                                        onChange={e => setData('name', e.target.value)}
                                                        type="text"
                                                        id="name"
                                                        className="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                                                        placeholder=""
                                                        required=""
                                                    />
                                                    {errors.name && <div className="text-red-600 text-xs mt-2">{errors.name}</div>}
                                                </div>
                                                <div className="mb-5">
                                                    <label
                                                        htmlFor="website"
                                                        className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                                    >
                                                        Website
                                                    </label>
                                                    <input
                                                        value={data.website}
                                                        onChange={e => setData('website', e.target.value)}
                                                        type="text"
                                                        id="website"
                                                        className="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                                                        required=""
                                                    />
                                                    {errors.website && <div className="text-red-600 text-xs mt-2">{errors.website}</div>}
                                                </div>
                                                <div className="mb-5">
                                                    <label
                                                        htmlFor="phone"
                                                        className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                                    >
                                                        Phone number
                                                    </label>
                                                    <input
                                                        value={data.phone}
                                                        onChange={e => setData('phone', e.target.value)}
                                                        type="text"
                                                        id="phone"
                                                        className="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                                                        required=""
                                                    />
                                                    {errors.phone && <div className="text-red-600 text-xs mt-2">{errors.phone}</div>}
                                                </div>
                                                <div className="mb-5">
                                                    <label
                                                        htmlFor="message"
                                                        className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                                    >
                                                        About
                                                    </label>
                                                    <Editor
                                                        apiKey='66y1xewaxqzfezu1ryf9nq34zgmcbjzazz3cyvamp01t16bl'
                                                        onInit={(evt, editor) => editorRef.current = editor}
                                                        initialValue="<p>This is the initial content of the editor.</p>"
                                                        onEditorChange={(newValue, editor) => {
                                                            // setValue(newValue);
                                                            // setText(editor.getContent({format: 'text'}));
                                                            setData('about', editor.setContent(newValue));
                                                          }}
                                                        init={{
                                                            height: 400,
                                                            menubar: false,
                                                            plugins: [
                                                                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                                                                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                                                                'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
                                                            ],
                                                            toolbar: 'undo redo | blocks | ' +
                                                                'bold italic forecolor | alignleft aligncenter ' +
                                                                'alignright alignjustify | bullist numlist outdent indent | ' +
                                                                'removeformat | help',
                                                            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
                                                        }}
                                                    />
                                                </div>
                                                <div className="flex items-start mb-5">
                                                    <div className="flex items-center h-5">
                                                        <input
                                                            id="terms"
                                                            type="checkbox"
                                                            defaultValue=""
                                                            className="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800"
                                                            required=""
                                                        />
                                                    </div>
                                                    <label
                                                        htmlFor="terms"
                                                        className="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    >
                                                        I agree with the{" "}
                                                        <a href="#" className="text-blue-600 hover:underline dark:text-blue-500">
                                                            terms and conditions
                                                        </a>
                                                    </label>
                                                </div>
                                                <button
                                                    disabled={processing}
                                                    type="submit"
                                                    className="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                >
                                                    Lưu
                                                </button>
                                            </div>
                                            <div className="md:basis-2/5">
                                                <div className="mb-5">
                                                    <label className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an city</label>
                                                    <select
                                                        onChange={handleChangeCity}
                                                        defaultValue={""}
                                                        className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                        <option value="">Choose a city</option>
                                                        <optgroup label="Thành phố" className="font-semibold text-base">
                                                            {props.city.filter((item) => item.type === 'Thành phố Trung ương').map((item) => (<option key={item.matp} value={item.matp}>{item.name}</option>))}
                                                        </optgroup>
                                                        <optgroup label="Tỉnh" className="font-semibold text-base">
                                                            {props.city.filter((item) => item.type === 'Tỉnh').map((item) => (<option key={item.matp} value={item.matp}>{item.name}</option>))}
                                                        </optgroup>
                                                    </select>
                                                    {errors.state && <div className="text-red-600 text-xs mt-2">{errors.state}</div>}
                                                </div>
                                                <div className="mb-5">
                                                    <label className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an state</label>
                                                    <select
                                                        onChange={handleChangeState}
                                                        defaultValue={""}
                                                        className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                        <option value="">Choose a state</option>
                                                        <optgroup label="Thành phố" className="font-semibold text-base">
                                                            {state.filter((item) => item.type === 'Thành phố').map((item) => (<option key={item.maqh} value={item.maqh}>{item.name}</option>))}
                                                        </optgroup>
                                                        <optgroup label="Quận" className="font-semibold text-base">
                                                            {state.filter((item) => item.type === 'Quận').map((item) => (<option key={item.maqh} value={item.maqh}>{item.name}</option>))}
                                                        </optgroup>
                                                        <optgroup label="Huyện" className="font-semibold text-base">
                                                            {state.filter((item) => item.type === 'Huyện').map((item) => (<option key={item.maqh} value={item.maqh}>{item.name}</option>))}
                                                        </optgroup>
                                                    </select>
                                                    {errors.city && <div className="text-red-600 text-xs mt-2">{errors.city}</div>}
                                                </div>
                                                <div className="mb-5">
                                                    <label className="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an street</label>
                                                    <select
                                                        onChange={(e) => setData('street', e.target.value)}
                                                        defaultValue={""}
                                                        className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                        <option value="">Choose a street</option>
                                                        <optgroup label="Xã" className="font-semibold text-base">
                                                            {street.filter((item) => item.type === 'Xã').map((item) => (<option key={item.xaid} value={item.xaid}>{item.name}</option>))}
                                                        </optgroup>
                                                        <optgroup label="Phường" className="font-semibold text-base">
                                                            {street.filter((item) => item.type === 'Phường').map((item) => (<option key={item.xaid} value={item.xaid}>{item.name}</option>))}
                                                        </optgroup>
                                                        <optgroup label="Thị trấn" className="font-semibold text-base">
                                                            {street.filter((item) => item.type === 'Thị trấn').map((item) => (<option key={item.xaid} value={item.xaid}>{item.name}</option>))}
                                                        </optgroup>
                                                    </select>
                                                    {errors.street && <div className="text-red-600 text-xs mt-2">{errors.street}</div>}
                                                </div>
                                                <div className="mb-5">
                                                    <label
                                                        htmlFor="zip"
                                                        className="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                                    >
                                                        Zip
                                                    </label>
                                                    <input
                                                        value={data.zip}
                                                        onChange={e => setData('zip', e.target.value)}
                                                        type="number"
                                                        id="zip"
                                                        className="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                                                        required=""
                                                    />
                                                    {errors.zip && <div className="text-red-600 text-xs mt-2">{errors.zip}</div>}
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Authenticated>
    )
}
